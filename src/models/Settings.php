<?php
namespace verbb\comments\models;

use verbb\comments\Comments;
use verbb\comments\elements\Comment;
use verbb\comments\enums\CommentStatus;

use Craft;
use craft\base\ElementInterface;
use craft\base\Model;
use craft\db\Table;
use craft\elements\Asset;
use craft\helpers\ArrayHelper;
use craft\helpers\Db;
use craft\helpers\DateTimeHelper;

class Settings extends Model
{
    // Public Properties
    // =========================================================================

    public string $structureUid = '';
    public bool $closed = false;
    public int $indexSidebarLimit = 25;
    public bool $indexSidebarGroup = true;
    public bool $indexSidebarIndividualElements = false;
    public array $defaultQueryStatus = [Comment::STATUS_APPROVED];

    // General
    public bool $allowGuest = false;
    public string $guestNotice = '';
    public bool $guestRequireEmailName = true;
    public bool $guestShowEmailName = true;
    public bool $requireModeration = true;
    public string $moderatorUserGroup = '';
    public mixed $autoCloseDays = null;
    public mixed $maxReplyDepth = null;
    public mixed $maxUserComments = null;

    // Voting
    public bool $allowVoting = true;
    public bool $allowGuestVoting = false;
    public int $downvoteCommentLimit = 5;
    public bool $hideVotingForThreshold = false;

    // Flagging
    public bool $allowFlagging = true;
    public bool $allowGuestFlagging = false;
    public int $flaggedCommentLimit = 5;

    // Templates - Default
    public bool $showAvatar = true;
    public ElementInterface|null|string $placeholderAvatar = '';
    public bool $enableGravatar = false;
    public bool $showTimeAgo = true;
    public bool $outputDefaultCss = true;
    public bool $outputDefaultJs = true;

    // Templates - Custom
    public string $templateFolderOverride = '';
    public string $templateEmail = '';

    // Security
    public bool $enableSpamChecks = true;
    public string $securityMaxLength = '';
    public string $securityFlooding = '';
    public string $securityModeration = '';
    public string $securitySpamlist = '';
    public string $securityBanned = '';
    public bool $securityMatchExact = false;
    public bool $recaptchaEnabled = false;
    public string $recaptchaKey = '';
    public string $recaptchaSecret = '';

    // Notifications
    public bool $notificationAuthorEnabled = true;
    public bool $notificationReplyEnabled = true;
    public bool $notificationSubscribeAuto = false;
    public bool $notificationSubscribeDefault = true;
    public bool $notificationSubscribeEnabled = false;
    public bool $notificationSubscribeCommentEnabled = false;
    public bool $notificationModeratorEnabled = false;
    public bool $notificationModeratorApprovedEnabled = false;
    public array $notificationAdmins = [];
    public bool $notificationAdminEnabled = false;
    public bool $notificationFlaggedEnabled = false;
    public bool $useQueueForNotifications = false;

    // Permissions
    public array $permissions = [];

    // Users
    public array $users = [];

    // Custom Fields
    public bool $showCustomFieldNames = false;
    public bool $showCustomFieldInstructions = false;

    // CP Sorting
    public string $sortDefaultKey = 'structure';
    public string $sortDefaultDirection = 'asc';

    private ?ElementInterface $_placeholderAvatar = null;


    // Public Methods
    // =========================================================================

    public function setAttributes($values, $safeOnly = true): void
    {
        // Typecast some settings
        $arrays = ['notificationAdmins'];

        foreach ($arrays as $array) {
            if (isset($values[$array]) && !is_array($values[$array])) {
                $values[$array] = [$values[$array]];
            }
        }

        parent::setAttributes($values, $safeOnly);
    }

    public function getPlaceholderAvatar(): ?ElementInterface
    {
        if ($this->_placeholderAvatar !== null) {
            return $this->_placeholderAvatar;
        }

        if ($this->placeholderAvatar && isset($this->placeholderAvatar[0])) {
            return $this->_placeholderAvatar = Craft::$app->getElements()->getElementById($this->placeholderAvatar[0], Asset::class);
        }

        return null;
    }

    public function canComment($element): bool
    {
        $isAllowed = $this->commentingAvailable($element);

        return $isAllowed['permission'];
    }

    public function commentingAvailable($element): array
    {
        $isClosed = Comments::$plugin->getComments()->checkManuallyClosed($element);

        if ($isClosed) {
            return CommentStatus::ManuallyClosed;
        }

        $isExpired = Comments::$plugin->getComments()->checkExpired($element);

        if ($isExpired) {
            return CommentStatus::Expired;
        }

        $hasPermission = Comments::$plugin->getComments()->checkPermissions($element);

        if (!$hasPermission) {
            return CommentStatus::Unpermitted;
        }

        $currentUser = Comments::$plugin->getService()->getUser();

        if (!$currentUser && !$this->allowGuest) {
            return CommentStatus::NoGuests;
        }

        if ($this->maxUserComments && $currentUser) {
            // Has the user already commented X amount of times on this element?
            $count = Comment::find()->ownerId($element->id)->userId($currentUser->id)->count();

            if ($count >= $this->maxUserComments) {
                return CommentStatus::TooManyComments;
            }
        }

        return CommentStatus::Allowed;
    }

    public function getStructureId(): ?int
    {
        if ($this->structureUid) {
            return Db::idByUid(Table::STRUCTURES, $this->structureUid);
        }

        // Create the structure if it doesn't exist
        if ($structure = Comments::$plugin->createAndStoreStructure()) {
            $this->structureUid = $structure->uid;

            return $structure->id;
        }

        return null;
    }

    public function getEnabledNotificationAdmins(): array
    {
        $notificationAdmins = $this->notificationAdmins ?: [];

        return ArrayHelper::where($notificationAdmins, 'enabled');
    }
}
