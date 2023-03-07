<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventMeta;
use App\Models\EventProgram;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * This relies on EventProgramSeeder being run first.
 */
class EventSeeder extends Seeder
{
    public function run(): void
    {
        // Gallery Tour, early
        $event = Event::create([
            'published' => true,
            'publish_start_date' => Carbon::yesterday(),
            'title' => 'Gallery Tour (Thursday at 1:00, Grand Staircase start)',
            'title_display' => 'Gallery Tour',
            'location' => 'Meet in Griffin Court',
            'list_description' => "<p>Looking for a good place to start your museum visit? Join a knowledgeable guide for a 45-minute tour of museum icons and lesser-known treasures. This tour starts in the Modern Wing's Griffin Court. </p>",
            'short_description' => "<p>Looking for a good place to start your museum visit? Join a knowledgeable guide for a 45-minute tour of museum icons and lesser-known treasures. This tour starts in the Modern Wing's Griffin Court.</p>",
            'start_time' => 'PT13H00M',
            'end_time' => 'PT13H45M',
            'forced_date' => 'Every Thursday | 1:00-1:45',
            'is_admission_required' => false,
            'is_free' => true,
            'is_registration_required' => false,
            'is_rsvp' => false,
            'is_ticketed' => false,
        ]);
        $eventProgram = EventProgram::firstWhere(['name' => 'Verbal Description Tours']);
        $event->programs()->attach($eventProgram->id);
        $eventMeta = EventMeta::create([
            'event_id' => $event->id,
            'date' => now()->addHours(1),
            'date_end' => now()->addHours(1)->addMinutes(45),
        ]);
        $event->eventMetas()->save($eventMeta);

        // Gallery Tour, late
        $event = Event::create([
            'published' => true,
            'publish_start_date' => Carbon::yesterday(),
            'title' => 'Gallery Tour (Thursday at 3:00, Grand Staircase start)',
            'title_display' => 'Gallery Tour',
            'location' => 'Meet in Griffin Court',
            'list_description' => "<p>Looking for a good place to start your museum visit? Join a knowledgeable guide for a 45-minute tour of museum icons and lesser-known treasures. This tour starts in the Modern Wing's Griffin Court. </p>",
            'short_description' => "<p>Looking for a good place to start your museum visit? Join a knowledgeable guide for a 45-minute tour of museum icons and lesser-known treasures. This tour starts in the Modern Wing's Griffin Court.</p>",
            'start_time' => 'PT15H00M',
            'end_time' => 'PT15H45M',
            'forced_date' => 'Every Thursday | 3:00-3:45',
            'is_admission_required' => false,
            'is_free' => true,
            'is_registration_required' => false,
            'is_rsvp' => false,
            'is_ticketed' => false,
        ]);
        $eventProgram = EventProgram::firstWhere(['name' => 'Verbal Description Tours']);
        $event->programs()->attach($eventProgram->id);
        $eventMeta = EventMeta::create([
            'event_id' => $event->id,
            'date' => now()->addHours(3),
            'date_end' => now()->addHours(3)->addMinutes(45),
        ]);
        $event->eventMetas()->save($eventMeta);

        // The Art Exchange
        $event = Event::create([
            'published' => true,
            'publish_start_date' => Carbon::yesterday(),
            'title' => 'The Art Exchange (Feb 24–27)',
            'location' => 'Ryan Learning Center',
            'list_description' => "<p>Visitors of all ages are invited to stop by the Ryan Learning Center and explore a variety of activities.</p>",
            'short_description' => "<p>Visitors of all ages are invited to stop by the Ryan Learning Center and explore a variety of activities.</p>",
            'start_time' => 'PT11H00M',
            'end_time' => 'PT15H00M',
            'forced_date' => 'Feb24-27 | 11:00-3:00',
            'is_admission_required' => false,
            'is_free' => true,
            'is_registration_required' => false,
            'is_rsvp' => false,
            'is_ticketed' => false,
            'title_display' => 'The Art Exchange',
        ]);
        $eventProgram = EventProgram::firstWhere(['name' => 'Artists Connect']);
        $event->programs()->attach($eventProgram->id);
        $eventMetas = [
            EventMeta::create([
                'event_id' => $event->id,
                'date' => Carbon::yesterday()->setHour(11),
                'date_end' => Carbon::yesterday()->setHour(15),
            ]),
            EventMeta::create([
                'event_id' => $event->id,
                'date' => today()->setHour(11),
                'date_end' => today()->setHour(15),
            ]),
            EventMeta::create([
                'event_id' => $event->id,
                'date' => Carbon::tomorrow()->setHour(11),
                'date_end' => Carbon::tomorrow()->setHour(15),
            ]),
            EventMeta::create([
                'event_id' => $event->id,
                'date' => today()->addDays(2)->setHour(11),
                'date_end' => today()->addDays(2)->setHour(15),
            ]),
        ];
        $event->eventMetas()->saveMany($eventMetas);

        // Lecture
        $event = Event::create([
            'published' => true,
            'publish_start_date' => Carbon::yesterday(),
            'title' => 'Lecture: Embracing the Moon-Chinese Ceramic Art, Old and New',
            'title_display' => 'Lecture: Embracing the Moon-Chinese Ceramic Art, Old and New',
            'location' => 'Fullerton Hall',
            'list_description' => "<p>Join Pritzker Chair of Arts of Asia and curator of Chinese art Tao Wang for a discussion of two newly acquired Chinese moon flasks.</p>",
            'short_description' => "<p>Join Pritzker Chair of Arts of Asia and curator of Chinese art Tao Wang for a discussion of two newly acquired Chinese moon flasks.</p>",
            'start_time' => 'PT14H00M',
            'end_time' => 'PT15H00M',
            'forced_date' => null,
            'is_admission_required' => false,
            'is_free' => false,
            'is_registration_required' => true,
            'is_rsvp' => false,
            'is_ticketed' => true,
        ]);
        $eventProgram = EventProgram::firstWhere(['name' => 'Lectures']);
        $event->programs()->attach($eventProgram->id);
        $eventMeta = EventMeta::create([
            'event_id' => $event->id,
            'date' => now()->addHours(12),
            'date_end' => now()->addHours(13),
        ]);
        $event->eventMetas()->save($eventMeta);
    }
}
