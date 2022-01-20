<?php

namespace HexaStudio\Server;


class UserAgent
{

    private static string $userAgent;

    public static function init()
    {
        UserAgent::$userAgent = $_SERVER["HTTP_USER_AGENT"];
    }

    public static function getOSType(string $name): int
    {
        $os_type = OSType::UNKNOWN;

        $os_type_array = array(
            'Windows 10' => OSType::WINDOWS,
            'Windows 8.1' => OSType::WINDOWS,
            'Windows 8' => OSType::WINDOWS,
            'Windows 7' => OSType::WINDOWS,
            'Windows Vista' => OSType::WINDOWS,
            'Windows Server 2003/XP x64' => OSType::WINDOWS,
            'Windows XP' => OSType::WINDOWS,
            'Windows 2000' => OSType::WINDOWS,
            'Windows ME' => OSType::WINDOWS,
            'Windows 98' => OSType::WINDOWS,
            'Windows 95' => OSType::WINDOWS,
            'Windows 3.11' => OSType::WINDOWS,
            'Mac OS X' => OSType::MACOS,
            'Mac OS 9' => OSType::MACOS,
            'Linux' => OSType::LINUX,
            'Ubuntu' => OSType::LINUX,
            'iPhone' => OSType::IOS,
            'iPod' => OSType::IOS,
            'iPad' => OSType::IOS,
            'Android' => OSType::ANDROID,
            'BlackBerry' => OSType::ANDROID,
            'Mobile' => OSType::ANDROID
        );

        foreach ($os_type_array as $type_name => $type)
            if ($type_name === $name)
                $os_type = $type;

        return $os_type;
    }

    public static function getOS(): string
    {
        $os_platform = "Unknown OS Platform";

        $os_array = array(
            '/windows nt 10/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );

        foreach ($os_array as $regex => $value)
            if (preg_match($regex, UserAgent::$userAgent))
                $os_platform = $value;

        return $os_platform;
    }

}