<?php

namespace Claroline\ForumBundle\Crud;

use Claroline\AppBundle\Event\Crud\CreateEvent;
use Claroline\AppBundle\Persistence\ObjectManager;
use Claroline\CoreBundle\Entity\Resource\ResourceNode;
use Claroline\CoreBundle\Security\PermissionCheckerTrait;
use Claroline\ForumBundle\Entity\Forum;
use Claroline\ForumBundle\Entity\Message;
use Claroline\ForumBundle\Entity\Validation\User as UserValidation;
use Claroline\ForumBundle\Manager\ForumManager;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MessageCrud
{
    use PermissionCheckerTrait;

    /** @var ObjectManager */
    private $om;

    /** @var ForumManager */
    private $forumManager;

    /**
     * MessageCrud constructor.
     *
     * @param ObjectManager                 $om
     * @param ForumManager                  $forumManager
     * @param AuthorizationCheckerInterface $authorization
     */
    public function __construct(
        ObjectManager $om,
        ForumManager $forumManager,
        AuthorizationCheckerInterface $authorization
    ) {
        $this->om = $om;
        $this->forumManager = $forumManager;
        $this->authorization = $authorization;
    }

    /**
     * Manage moderation on message create.
     *
     * @param CreateEvent $event
     *
     * @return ResourceNode
     */
    public function preCreate(CreateEvent $event)
    {
        /** @var Message $message */
        $message = $event->getObject();
        $forum = $message->getSubject()->getForum();

        //create user if not here
        $user = $this->om->getRepository(UserValidation::class)->findOneBy([
            'user' => $message->getCreator(),
            'forum' => $forum,
        ]);

        if (!$user) {
            $user = new UserValidation();
            $user->setForum($forum);
            $user->setUser($message->getCreator());
        }
        if (!$this->checkPermission('EDIT', $forum->getResourceNode())) {
            if (Forum::VALIDATE_PRIOR_ALL === $forum->getValidationMode()) {
                $message->setModerated(Forum::VALIDATE_PRIOR_ALL);
            }

            if (Forum::VALIDATE_PRIOR_ONCE === $forum->getValidationMode()) {
                $message->setModerated($user->getAccess() ? Forum::VALIDATE_NONE : Forum::VALIDATE_PRIOR_ONCE);
            }
        } else {
            $message->setModerated(Forum::VALIDATE_NONE);
        }

        return $message;
    }

    /**
     * Send notifications after creation.
     *
     * @param CreateEvent $event
     *
     * @return Message
     */
    public function postCreate(CreateEvent $event)
    {
        /** @var Message $message */
        $message = $event->getObject();

        $this->forumManager->notifyMessage($message);

        return $message;
    }
}
