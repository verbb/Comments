<?php

return [
  //
  // Email Messages
  //
  'comments_author_notification_heading' => 'When a comment is received:',
  'comments_author_notification_subject' => '"{{element.title}}" has received a comment on {{siteName}}.',
  'comments_author_notification_body' => "Hi {{user.friendlyName}},\n\n" .
    "A new comment on the post \"{{ element.title }}\" has been made.\n\n" .
    "{{element.url}}#comment-{{comment.id}}.",

  'comments_reply_notification_heading' => 'When someone replies to another comment:',
  'comments_reply_notification_subject' => 'Someone has replied to your comment on {{siteName}}.',
  'comments_reply_notification_body' => "Hi {{user.friendlyName}},\n\n" .
    "A new reply to your comment on the post \"{{ element.title }}\" has been made.\n\n" .
    "{{element.url}}#comment-{{comment.id}}.",

  'comments_subscriber_notification_element_heading' => 'When a comment is made on a subscribed element:',
  'comments_subscriber_notification_element_subject' => 'A new comment has been made on {{ element.title }}',
  'comments_subscriber_notification_element_body' => "Hi {{user.friendlyName}},\n\n" .
    "A new comment on the post \"{{ element.title }}\" has been made.\n\n" .
    "{{element.url}}#comment-{{comment.id}}.",

  'comments_subscriber_notification_comment_heading' => 'When someone replies to another comment they have subscribed to:',
  'comments_subscriber_notification_comment_subject' => 'A new reply has been made on {{ element.title }}',
  'comments_subscriber_notification_comment_body' => "Hi {{user.friendlyName}},\n\n" .
    "A new reply on the post \"{{ element.title }}\" has been made.\n\n" .
    "{{element.url}}#comment-{{comment.id}}.",

  'comments_moderator_notification_heading' => 'When a comment has been made, and awaits moderation:',
  'comments_moderator_notification_subject' => 'A new comment requires moderation on {{ siteName }}',
  'comments_moderator_notification_body' => "Hi {{user.friendlyName}},\n\n" .
    "A new comment on the post \"{{ element.title }}\" has been made and requires moderation.\n\n" .
    "{{comment.cpEditUrl}}.",

  'comments_moderator_edit_notification_heading' => 'When a comment has been edited, and awaits moderation:',
  'comments_moderator_edit_notification_subject' => 'Someone has edited their comment and requires moderation on {{siteName}}.',
  'comments_moderator_edit_notification_body' => "Hi {{user.friendlyName}},\n\n" .
    "A comment on the post \"{{ element.title }}\" was edited and requires moderation.\n\n" .
    "{{comment.cpEditUrl}}.",

  'comments_moderator_approved_notification_heading' => 'When a comment has been approved via moderation:',
  'comments_moderator_approved_notification_subject' => 'Your comment has been approved on {{ siteName }}',
  'comments_moderator_approved_notification_body' => "Hi {{user.friendlyName}},\n\n" .
    "Your comment has been approved on the post \"{{ element.title }}\".\n\n" .
    "{{element.url}}#comment-{{comment.id}}.",

  'comments_admin_notification_heading' => 'When a comment is received by an admin:',
  'comments_admin_notification_subject' => '"{{element.title}}" has received a comment on {{siteName}}.',
  'comments_admin_notification_body' => "Hi,\n\n" .
    "A new comment on the post \"{{ element.title }}\" has been made.\n\n" .
    "{{comment.cpEditUrl}}.",

  'comments_flag_notification_heading' => 'When a comment has received a flag:',
  'comments_flag_notification_subject' => '"{{element.title}}" has received a comment flag on {{siteName}}.',
  'comments_flag_notification_body' => "Hi,\n\n" .
    "A comment has been flagged on the post \"{{ element.title }}\".\n\n" .
    "{{comment.cpEditUrl}}.",

  'Add a comment...' => 'Add a comment...',
  'Administrators' => 'Administrators',
  'All comments' => 'All comments',
  'All {elements}' => 'All {elements}',
  'Approved' => 'Approved',
  'Are you sure you want to delete the selected comments?' => 'Are you sure you want to delete the selected comments?',
  'Are you sure you want to delete this comment?' => 'Are you sure you want to delete this comment?',
  'Close' => 'Close',
  'Comment' => 'Comment',
  'Comment blocked due to security policy.' => 'Comment blocked due to security policy.',
  'Comment deleted.' => 'Comment deleted.',
  'Comment hidden due to low rating' => 'Comment hidden due to low rating',
  'Comment marked as inappropriate' => 'Comment marked as inappropriate',
  'Comment must be shorter than {limit} characters.' => 'Comment must be shorter than {limit} characters.',
  'Comment must not be blank.' => 'Comment must not be blank.',
  'Comment not allowed.' => 'Comment not allowed.',
  'Comment Options' => 'Comment Options',
  'Comments' => 'Comments',
  'Comments are disabled for this element.' => 'Comments are disabled for this element.',
  'Comment saved successfully.' => 'Comment saved successfully.',
  'Comments deleted.' => 'Comments deleted.',
  'Couldn’t save comment.' => 'Couldn’t save comment.',
  'Create comments' => 'Create comments',
  'Created Date' => 'Created Date',
  'CSS/JS Resources' => 'CSS/JS Resources',
  'Date' => 'Date',
  'Delete' => 'Delete',
  'Delete comments' => 'Delete comments',
  'Edit' => 'Edit',
  'Edit other users’ comments' => 'Edit other users’ comments',
  'Element' => 'Element',
  'Email' => 'Email',
  'Email is required.' => 'Email is required.',
  'Flag' => 'Flag',
  'Flagged' => 'Flagged',
  'Flagging is not allowed.' => 'Flagging is not allowed.',
  'For more fine-grained control over specific elements, create a Comment Options fieldtype, and add to your elements custom fields.' => 'For more fine-grained control over specific elements, create a Comment Options fieldtype, and add to your elements custom fields.',
  'Form validation failed. Marked as spam.' => 'Form validation failed. Marked as spam.',
  'Guest' => 'Guest',
  'If disabling any of these options, you‘ll need to supply your own CSS or JS in order for the form and comments functionality to look and work correctly.' => 'If disabling any of these options, you‘ll need to supply your own CSS or JS in order for the form and comments functionality to look and work correctly.',
  'IP Address' => 'IP Address',
  'Moderators' => 'Moderators',
  'Must be logged in to comment.' => 'Must be logged in to comment.',
  'Must be logged in to flag comments.' => 'Must be logged in to flag comments.',
  'Must be logged in to vote.' => 'Must be logged in to vote.',
  'Name' => 'Name',
  'Name is required.' => 'Name is required.',
  'No comments.' => 'No comments.',
  'No comment with the ID “{id}”' => 'No comment with the ID “{id}”',
  'No replies for this comment' => 'No replies for this comment',
  'Pending' => 'Pending',
  'Per-comment subscriptions are not allowed.' => 'Per-comment subscriptions are not allowed.',
  'Post comment' => 'Post comment',
  'Replies' => 'Replies',
  'Reply' => 'Reply',
  'Save' => 'Save',
  'Save comments' => 'Save comments',
  'Select which element collections should have commenting enabled on by default.' => 'Select which element collections should have commenting enabled on by default.',
  'Sending comment notification.' => 'Sending comment notification.',
  'Spam' => 'Spam',
  'Status' => 'Status',
  'Structure Info' => 'Structure Info',
  'Subscribe' => 'Subscribe',
  'Subscribed to discussion.' => 'Subscribed to discussion.',
  'Subscribe to get email updates for this discussion' => 'Subscribe to get email updates for this discussion',
  'Subscribing' => 'Subscribing',
  'The default templates are what is used when calling `craft.comments.render()`, and automatically outputs CSS and JS code in your templates. If you want full control over your templates, use [Custom Templates]({link}).' => 'The default templates are what is used when calling `craft.comments.render()`, and automatically outputs CSS and JS code in your templates. If you want full control over your templates, use [Custom Templates]({link}).',
  'These values should not be altered manually. If for some reason they are empty, you can run the following commend to re-generate these values: <code>php craft comments/base/resave-structure</code>' => 'These values should not be altered manually. If for some reason they are empty, you can run the following commend to re-generate these values: <code>php craft comments/base/resave-structure</code>',
  'Trashed' => 'Trashed',
  'Trash other users’ comments' => 'Trash other users’ comments',
  'Unable to delete comment.' => 'Unable to delete comment.',
  'Unable to modify another user’s comment.' => 'Unable to modify another user’s comment.',
  'Unable to update subscribe status.' => 'Unable to update subscribe status.',
  'Unsubscribed from discussion.' => 'Unsubscribed from discussion.',
  'Updated Date' => 'Updated Date',
  'URL' => 'URL',
  'User' => 'User',
  'User Agent' => 'User Agent',
  'View comments' => 'View comments',
  'Votes' => 'Votes',
  'Voting is not allowed.' => 'Voting is not allowed.',
  'Warning' => 'Warning',
  'You can only vote on a comment once.' => 'You can only vote on a comment once.',
  'You may only delete your own comments.' => 'You may only delete your own comments.',
  'You must be logged in to change your settings.' => 'You must be logged in to change your settings.',
  'Your comment has been posted and is under review.' => 'Your comment has been posted and is under review.',
  'Your email' => 'Your email',
  'Your name' => 'Your name',
  '[Deleted element]' => '[Deleted element]',
  '[Deleted User]' => '[Deleted User]',
];