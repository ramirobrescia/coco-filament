<?php

namespace App;

enum PurchaseState
{
    case OPEN;
    case CLOSED;
    case ORDERED;
    case PREPARING;
    case DELIVERED;
    case RECIVED;
}
