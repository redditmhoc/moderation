<?php

namespace App\Enums;

enum PlatformEnum: string
{
    case Reddit = 'REDDIT';
    case Discord = 'DISCORD';
    case Both = 'BOTH';
}
