<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\CoreBundle\Controller\APINew\Cryptography;

use Claroline\AppBundle\Controller\AbstractCrudController;
use Claroline\CoreBundle\Entity\Cryptography\ApiToken;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("apitoken")
 */
class ApiTokenController extends AbstractCrudController
{
    /** @var AuthorizationCheckerInterface */
    private $authorization;
    /** @var TokenStorageInterface */
    private $tokenStorage;

    public function __construct(
        AuthorizationCheckerInterface $authorization,
        TokenStorageInterface $tokenStorage
    ) {
        $this->authorization = $authorization;
        $this->tokenStorage = $tokenStorage;
    }

    public function getClass()
    {
        return ApiToken::class;
    }

    public function getName()
    {
        return 'apitoken';
    }

    protected function getDefaultHiddenFilters()
    {
        $tool = $this->om->getRepository('ClarolineCoreBundle:Tool\AdminTool')
            ->findOneBy(['name' => 'integration']);

        if (!$this->authorization->isGranted('OPEN', $tool)) {
            // only list tokens of the current token for non admins
            return [
                'user' => $this->tokenStorage->getToken()->getUser(),
            ];
        }

        return [];
    }

    /**
     * @Route("/list/current", name="apiv2_apitoken_list_current", methods={"GET"})
     */
    public function getCurrentAction(Request $request): JsonResponse
    {
        $query = $request->query->all();
        $options = $this->options['list'];

        if (isset($query['options'])) {
            $options = $query['options'];
        }

        $query['hiddenFilters'] = [
            'user' => $this->tokenStorage->getToken()->getUser(),
        ];

        return new JsonResponse($this->finder->search(
            $this->getClass(),
            $query,
            $options
        ));
    }
}
