<?php

namespace Icap\WikiBundle\Listener;

use Claroline\CoreBundle\Entity\Resource\AbstractResourceEvaluation;
use Claroline\CoreBundle\Event\Resource\CopyResourceEvent;
use Claroline\CoreBundle\Event\CreateFormResourceEvent;
use Claroline\CoreBundle\Event\CreateResourceEvent;
use Claroline\CoreBundle\Event\Resource\DeleteResourceEvent;
use Claroline\CoreBundle\Event\GenericDataEvent;
use Claroline\CoreBundle\Event\Resource\OpenResourceEvent;
use Icap\WikiBundle\Entity\Wiki;
use Icap\WikiBundle\Form\WikiType;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * @DI\Service()
 */
class WikiListener
{
    private $container;
    private $httpKernel;
    private $request;

    /**
     * @DI\InjectParams({
     *     "container"    = @DI\Inject("service_container"),
     *     "httpKernel"   = @DI\Inject("http_kernel"),
     *     "requestStack" = @DI\Inject("request_stack")
     * })
     */
    public function __construct(ContainerInterface $container, HttpKernelInterface $httpKernel, RequestStack $requestStack)
    {
        $this->container = $container;
        $this->httpKernel = $httpKernel;
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @DI\Observe("create_form_icap_wiki")
     *
     * @param CreateFormResourceEvent $event
     */
    public function onCreateForm(CreateFormResourceEvent $event)
    {
        $form = $this->container->get('form.factory')->create(new WikiType(), new Wiki());
        $content = $this->container->get('templating')->render(
            'ClarolineCoreBundle:Resource:createForm.html.twig',
            [
                'form' => $form->createView(),
                'resourceType' => 'icap_wiki',
            ]
        );
        $event->setResponseContent($content);
        $event->stopPropagation();
    }

    /**
     * @DI\Observe("create_icap_wiki")
     *
     * @param CreateResourceEvent $event
     */
    public function onCreate(CreateResourceEvent $event)
    {
        $form = $this->container->get('form.factory')->create(new WikiType(), new Wiki());
        $form->handleRequest($this->request);

        if ($form->isValid()) {
            $wiki = $form->getData();
            $event->setResources([$wiki]);
        } else {
            $content = $this->container->get('templating')->render(
                'ClarolineCoreBundle:Resource:createForm.html.twig',
                [
                    'form' => $form->createView(),
                    'resourceType' => 'icap_wiki',
                ]
            );
            $event->setErrorFormContent($content);
        }
        $event->stopPropagation();
    }

    /**
     * @DI\Observe("open_icap_wiki")
     *
     * @param OpenResourceEvent $event
     */
    public function onOpen(OpenResourceEvent $event)
    {
        $params = [];
        $params['_controller'] = 'IcapWikiBundle:Wiki:view';
        $params['wikiId'] = $event->getResource()->getId();
        $params['_format'] = 'html';
        $subRequest = $this->request->duplicate([], null, $params);
        $response = $this->httpKernel
            ->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
        $event->setResponse($response);
        $event->stopPropagation();
    }

    /**
     * @DI\Observe("delete_icap_wiki")
     *
     * @param DeleteResourceEvent $event
     */
    public function onDelete(DeleteResourceEvent $event)
    {
        $em = $this->container->get('claroline.persistence.object_manager');
        $em->remove($event->getResource());
        $em->flush();
        $event->stopPropagation();
    }

    /**
     * @DI\Observe("copy_icap_wiki")
     *
     * @param CopyResourceEvent $event
     */
    public function onCopy(CopyResourceEvent $event)
    {
        $wiki = $event->getResource();
        $loggedUser = $this->container->get('security.token_storage')->getToken()->getUser();
        $newWiki = $this->container->get('icap.wiki.manager')->copyWiki($wiki, $loggedUser);
        $event->setCopy($newWiki);
        $event->stopPropagation();
    }

    /**
     * @DI\Observe("generate_resource_user_evaluation_icap_wiki")
     *
     * @param GenericDataEvent $event
     */
    public function onGenerateResourceTracking(GenericDataEvent $event)
    {
        $om = $this->container->get('claroline.persistence.object_manager');
        $resourceEvalManager = $this->container->get('claroline.manager.resource_evaluation_manager');
        $data = $event->getData();
        $node = $data['resourceNode'];
        $user = $data['user'];
        $startDate = $data['startDate'];

        $logs = $resourceEvalManager->getLogsForResourceTracking(
            $node,
            $user,
            ['resource-read', 'resource-icap_wiki-section_create', 'resource-icap_wiki-section_update'],
            $startDate
        );
        $nbLogs = count($logs);

        if ($nbLogs > 0) {
            $om->startFlushSuite();
            $tracking = $resourceEvalManager->getResourceUserEvaluation($node, $user);
            $tracking->setDate($logs[0]->getDateLog());
            $status = AbstractResourceEvaluation::STATUS_UNKNOWN;
            $nbAttempts = 0;
            $nbOpenings = 0;

            foreach ($logs as $log) {
                switch ($log->getAction()) {
                    case 'resource-read':
                        ++$nbOpenings;

                        if ($status === AbstractResourceEvaluation::STATUS_UNKNOWN) {
                            $status = AbstractResourceEvaluation::STATUS_OPENED;
                        }
                        break;
                    case 'resource-icap_wiki-section_create':
                    case 'resource-icap_wiki-section_update':
                        ++$nbAttempts;
                        $status = AbstractResourceEvaluation::STATUS_PARTICIPATED;
                        break;
                }
            }
            $tracking->setStatus($status);
            $tracking->setNbAttempts($nbAttempts);
            $tracking->setNbOpenings($nbOpenings);
            $om->persist($tracking);
            $om->endFlushSuite();
        }
        $event->stopPropagation();
    }
}
