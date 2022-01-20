<?php

namespace HexaStudio\Server;

class OSType
{
    const WINDOWS = 0;
    const LINUX = 1;
    const MACOS = 2;
    const ANDROID = 3;
    const IOS = 4;

    const UNKNOWN = -1;

    private function __construct()
    {
    }
}