<?php

namespace Success\InviteBundle;

final class Events
{
    const REFERER_RELATION_PRE_PERSIST  = 'success.referer_relation.pre_persist';

    const REFERER_RELATION_POST_PERSIST = 'success.referer_relation.post_persist';

    const REFEREABLE_PRE_PERSIST        = 'success.refereable.pre_persist';
    
    const REFEREABLE_POST_PERSIST       = 'success.refereable.post_persist';
}
