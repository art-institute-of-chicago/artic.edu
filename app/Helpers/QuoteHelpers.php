<?php

namespace App\Helpers;

use Illuminate\Support\Collection;

class QuoteHelpers
{
    /**
     * Get an inspiring quote from an artists in the Art Institute of Chicago collection.
     *
     * @return string
     * @see Illuminate\Foundation\Inspiring
     */
    public static function quote()
    {
        return static::quotes()
            ->random();
    }

    /**
     * Get the collection of inspiring quotes.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function quotes()
    {
        return new Collection([
            'The use of color in my paintings is of paramount importance to me. Through color I have sought to concentrate on beauty and happiness, rather than on man\'s inhumanity to man. - Alma Thomas',
            'Art is the one place we all turn to for solace. - Carrie Mae Weems',
            'You can\'t sit around and wait for somebody to say who you are. You need to write it and paint it and do it. - Faith Ringgold',
            'I dream my painting and I paint my dream. - Vincent van Gogh',
            'There is nothing more truly artistic than to love people. - Vincent Van Gogh',
            'Color is my daylong obsession, joy, and torment. - Claude Monet',
            'I believe in humanity, in us. If you have a positive perspective of all people then there is good to be captured. - Bisa Butler',
            'Don\'t think about making art, just get it done. - Andy Warhol',
            'The world today doesn\'t make sense, so why should I paint pictures that do? - Pablo Picasso',
            'If I could say it in words there would be no reason to paint. - Edward Hopper',
            'No one sees the world the way I do, and that is my strength as an artist. - Georgia O\'Keeffe',
            'Have no fear of perfection—you\'ll never reach it. - Salvador Dali',
            'I don\'t believe in hope, I believe in action. There are always going to be complications, but to a large degree, everything is in your hands. - Kerry James Marshall',
            'I paint from remembered landscapes that I carry with me - and remembered feelings of them. - Joan Mitchell',
            'I have always wanted to paint my people just the way they were. - Archibald John Motley Jr.',
            'I am interested more than anything else in being a free person. My art is about art—embracing a vision of the future that is unlike past futures. - Richard Hunt',
        ]);
    }
}
