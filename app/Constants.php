<?php

namespace App;

class Constants
{
    const USER_ADMIN = 1;
    const USER_MEMBER = 2;

    const SUBSCRIPTION_STATUS_PENDING = 0;
    const SUBSCRIPTION_STATUS_ACTIVE = 1;
    const SUBSCRIPTION_STATUS_INACTIVE = 2;
    const SUBSCRIPTION_STATUS_SUSPENDED = 3;
    const SUBSCRIPTION_STATUS_CANCELLED = 4;

    const PAYMENT_STATUS_PENDING = 0;
    const PAYMENT_STATUS_PAID = 1;
    const PAYMENT_STATUS_PROCESSING = 2;
    const PAYMENT_STATUS_CANCLLED = 3;
    const PAYMENT_STATUS_EXPIIRED = 4;
    const PAYMENT_STATUS_REJECTED = 5;
    const PAYMENT_STATUS_REFUNDED = 6;
}