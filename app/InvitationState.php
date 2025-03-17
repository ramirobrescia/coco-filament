<?php

namespace App;

enum InvitationState
{
    case CREATED;
    case SENDED;
    case ERROR;
    case ACCEPTED;
    case REJECTED;
}
