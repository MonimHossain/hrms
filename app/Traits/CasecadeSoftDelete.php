<?php

namespace App\Traits;

trait CasecadeSoftDelete{

    public static function boot()
    {
        parent::boot();

        // cause a delete of a folder to cascade
        // to children so they are also deleted
        static::deleting(function($parent) {
            if ($parent->forceDeleting) {
                $parent->{$parent->casecadeSoftDeleteMethod}()->withTrashed()->get()
                    ->each(function($child) {
                        $child->forceDelete();
                    });

            } else {
                $parent->{$parent->casecadeSoftDeleteMethod}()->get()
                    ->each(function($child) {
                        $child->delete();
                    });
            }
        });

        // cause a restore of a parent to cascade
        // to children so they are also restored
        static::restoring(function($parent) {
            $parent->{$parent->casecadeSoftDeleteMethod}()->withTrashed()->get()
                ->each(function($child) {
                    $child->restore();
                });
        });
    }


}
