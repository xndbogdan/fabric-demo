<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Title extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['imdb_id', 'title', 'year', 'type'];

    protected $appends = ['poster_url', 'imdb_url'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('poster')
            ->singleFile();
    }

    public function getPosterUrlAttribute() {
        $mediaUrl = $this->getFirstMediaUrl('poster');
        return $mediaUrl !== '' ? $mediaUrl : 'https://via.placeholder.com/350x500';
    }

    public function getImdbUrlAttribute() {
        return 'https://www.imdb.com/title/' . $this->imdb_id;
    }
    
}
