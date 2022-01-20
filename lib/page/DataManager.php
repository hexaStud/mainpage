<?php


namespace HexaStudio\Page;



class DataManager
{
    /**
     * @var int
     */
    private static int $id = 0;

    /**
     * Creates an ID
     *
     * @return int
     */
    public static function getNewId(): int
    {
        DataManager::$id++;
        return DataManager::$id;
    }
}