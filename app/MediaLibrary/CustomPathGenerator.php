<?php

namespace App\MediaLibrary;

use App\Models\Article;
use App\Models\Expense;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\User;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\PathGenerator\PathGenerator;

/**
 * Class CustomPathGenerator
 * @package App\MediaLibrary
 */
class CustomPathGenerator implements PathGenerator
{
    /**
     * @param  Media  $media
     *
     * @return string
     */
    public function getPath(Media $media): string
    {
        $path = '{PARENT_DIR}'.DIRECTORY_SEPARATOR.$media->id.DIRECTORY_SEPARATOR;

        switch ($media->collection_name) {
            case User::COLLECTION_PROFILE_PICTURES:
                return str_replace('{PARENT_DIR}', 'profile-photos', $path);
            case Ticket::TICKET_ATTACHMENT_PATH;
                return str_replace('{PARENT_DIR}', 'tickets', $path);
            case Expense::EXPENSE_RECEIPT;
                return str_replace('{PARENT_DIR}', 'expenses', $path);
            case Setting::PATH;
                return str_replace('{PARENT_DIR}', 'settings', $path);
            case Article::COLLECTION_ARTICLE_PICTURES;
                return str_replace('{PARENT_DIR}', 'articles', $path);
            case 'default' :
                return '';
        }
    }

    /**
     * @param  Media  $media
     *
     * @return string
     */
    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media).'thumbnails/';
    }

    /**
     * @param  Media  $media
     *
     * @return string
     */
    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media).'rs-images/';
    }
}
