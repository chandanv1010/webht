<?php 
namespace App\Enums;


enum SlideEnum: string {
    
    const BANNER = 'banner';
    const MAIN = 'main-slide';
    const MOBILE = 'mobile-slide';

    public static function toArray(){
        return [
            self::BANNER => 'banner',
            self::MAIN => 'main-slide',
            self::MOBILE => 'mobile-slide'
        ];
    }

}