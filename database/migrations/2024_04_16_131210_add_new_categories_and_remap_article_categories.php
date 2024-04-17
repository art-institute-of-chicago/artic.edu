<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class () extends Migration {
    public function up(): void
    {
        // Remapping of One Theme, Multiple Voices to Staff Picks

        if (DB::table('categories')->where('name', 'One Theme, Multiple Voices')->exists()) {
            $themeId = DB::table('categories')->where('name', 'One Theme, Multiple Voices')->value('id');
        }

        if (DB::table('categories')->where('name', 'Staff Picks')->exists()) {
            $staffPicksId = DB::table('categories')->where('name', 'Staff Picks')->value('id');
        }

        if (isset($themeId) && isset($staffPicksId)) {
            DB::table('article_category')
                ->where('category_id', $themeId)
                ->update(['category_id' => $staffPicksId]);

            // Now we can delete the old category

            DB::table('categories')
                ->where('id', $themeId)
                ->delete();
        }

        // I don't love this but it is what it is

        $articleCategories = [
            ['name' => 'Modern Art', 'ids' => [920, 936, 816, 830, 981, 982, 1083, 18, 138, 139, 206, 262, 356, 373, 375, 483, 598, 650, 654, 667, 698, 706, 738, 753, 763, 770, 781, 808, 821, 868, 877, 889, 890, 910, 913, 916, 930, 949, 971, 976, 991, 993, 1016, 1017, 1022, 1031, 1033, 1036, 1045, 1046, 1058, 1094, 1097]],
            ['name' => 'Contemporary Art', 'ids' => [102, 672, 733, 759, 863, 876, 891, 927, 984, 994, 1034, 1067, 816, 830, 981, 982, 1083, 81, 177, 200, 207, 258, 308, 309, 312, 403, 531, 550, 595, 621, 646, 684, 712, 714, 716, 724, 725, 748, 760, 762, 769, 771, 772, 782, 783, 785, 786, 789, 794, 820, 828, 835, 836, 844, 847, 848, 849, 853, 858, 861, 870, 878, 879, 881, 882, 884, 887, 895, 898, 907, 917, 918, 921, 925, 934, 937, 940, 958, 964, 967, 970, 973, 992, 997, 1000, 1006, 1010, 1013, 1014, 1023, 1041, 1044, 1050, 1066]],
            ['name' => 'Arts of Asia', 'ids' => [102, 672, 733, 759, 863, 876, 891, 927, 984, 994, 1034, 1067, 920, 936, 34, 629, 630, 674, 718, 719, 721, 743, 766, 799, 833, 840, 865, 871, 896, 897, 905, 912, 951, 963, 972, 986, 995, 1004, 1048, 1049, 1062, 1076]],
            ['name' => 'Arts of the Americas', 'ids' => [733, 759, 891, 927, 912, 963, 816, 1083, 312, 684, 724, 760, 789, 794, 820, 835, 836, 844, 847, 849, 853, 861, 870, 878, 879, 895, 898, 907, 917, 918, 921, 934, 1014, 1023, 1044, 138, 598, 650, 738, 753, 763, 770, 781, 808, 890, 913, 930, 949, 993, 1016, 1031, 1046, 1058, 74, 162, 228, 471, 549, 556, 586, 599, 605, 620, 625, 626, 631, 644, 649, 659, 660, 664, 665, 678, 682, 683, 687, 693, 694, 699, 702, 709, 720, 750, 765, 787, 795, 800, 802, 806, 818, 827, 834, 856, 869, 880, 903, 932, 948, 956, 960, 974, 990, 1015, 1029, 1037, 1060, 1098]],
            ['name' => 'Arts of Ancient Greek, Roman, and Byzantine Worlds', 'ids' => [994, 963, 967, 1044, 418, 662, 740, 787, 801, 831, 900, 904, 966, 989, 990, 998, 1008, 1018]],
            ['name' => 'Arts of Africa', 'ids' => [863, 994, 840, 896, 912, 972, 836, 848, 884, 925, 46, 451, 453, 643, 673, 732, 740, 751, 752, 767, 791, 819, 824, 825, 854, 900, 914, 956, 957, 977, 987, 990, 998, 1003, 1020, 1077, 1088]],
            ['name' => 'Textiles', 'ids' => [912, 714, 760, 858, 870, 878, 898, 958, 1041, 626, 680, 735, 798, 834, 901, 953, 987, 1005]],
            ['name' => 'Photography and Media', 'ids' => [863, 865, 905, 912, 963, 835, 853, 882, 887, 907, 925, 934, 958, 964, 967, 992, 1013, 262, 890, 1058, 222, 316, 467, 556, 581, 664, 686, 696, 701, 715, 731, 795, 801, 827, 867, 933, 938, 944, 987, 1019, 1042, 1057]],
            ['name' => 'European Painting and Sculpture', 'ids' => [920, 840, 1076, 981, 982, 748, 820, 836, 895, 967, 1066, 373, 375, 763, 889, 910, 916, 976, 991, 1058, 76, 141, 144, 151, 183, 248, 267, 325, 353, 386, 399, 436, 463, 490, 502, 547, 552, 553, 557, 562, 570, 572, 617, 628, 695, 697, 735, 737, 741, 746, 756, 757, 787, 806, 807, 810, 811, 813, 839, 846, 859, 862, 864, 880, 886, 899, 901, 911, 929, 950, 955, 969, 980, 985, 1012, 1035, 1037, 1052, 1053, 1069, 1093]],
            ['name' => 'Prints and Drawings', 'ids' => [672, 759, 876, 891, 920, 897, 905, 1049, 1062, 312, 646, 684, 724, 789, 879, 895, 918, 921, 967, 1006, 1044, 138, 738, 868, 877, 890, 910, 913, 930, 1017, 43, 55, 157, 227, 429, 448, 705, 729, 737, 744, 752, 755, 758, 765, 774, 813, 838, 839, 901, 908, 911, 945, 956, 1061]],
            ['name' => 'Medieval and Renaissance', 'ids' => [733, 840, 1044, 490, 502, 617, 622, 695, 780, 810, 811, 880, 955, 956, 983]],
            ['name' => 'European Design, pre-1900', 'ids' => [1004, 684, 181, 636, 953, 1071]],
            ['name' => 'Architecture and Design', 'ids' => [994, 34, 972, 785, 206, 913, 243, 540, 639, 668, 713, 800, 829, 851, 911, 943, 1070]],
            ['name' => 'Impressionism', 'ids' => [763, 770, 144, 353, 386, 399, 436, 463, 552, 572, 756, 807, 813, 846, 859, 862, 864, 886, 899, 969, 985]],
            ['name' => 'Surrealism', 'ids' => [889, 971, 1022, 1033, 1036, 1094, 1052]],
            ['name' => 'Arms and Armor', 'ids' => [733, 622]],
            ['name' => 'Japanese Prints', 'ids' => [891, 920, 674, 905, 1049, 1062, 821, 902]],
            ['name' => 'Ancient Art', 'ids' => [994, 840, 896, 905, 782, 967, 1044, 46, 451, 453, 459, 649, 702, 740, 767, 819, 824, 900, 901, 904, 956, 957, 966, 977, 989, 990, 998, 1008, 1018, 1088]],
            ['name' => 'Thorne Miniature Rooms', 'ids' => [733, 967, 339, 484, 551, 599, 661, 790]],
            ['name' => 'Chicago', 'ids' => [102, 34, 712, 724, 836, 861, 879, 918, 921, 992, 1013, 356, 763, 890, 74, 605, 652, 660, 678, 682, 686, 699, 710, 717, 720, 722, 726, 736, 765, 797, 829, 851, 864, 869, 899, 943, 979, 1002, 1029]],
            ['name' => 'Animals', 'ids' => [840, 905, 717, 774, 791, 798, 979, 1088]],
            ['name' => 'Meet the Staff', 'ids' => [995, 714, 540, 552, 597, 632, 648, 663, 679, 700, 708, 728, 742, 768, 778, 805, 850, 880, 900, 942, 952, 968, 1002, 1021, 1040, 1054, 1072]],
            ['name' => 'New Acquisition', 'ids' => [897, 1004, 550, 762, 139, 698, 1046, 222, 729, 732, 735, 741, 758, 780, 802, 989, 1018]],
            ['name' => 'External Voices', 'ids' => [986, 1013, 1023, 1066, 851, 1037, 1073, 1098]],
            ['name' => 'Interns and Fellows', 'ids' => [863, 865, 905, 830, 907, 964, 676, 730, 731, 734, 746, 751, 822, 965]],
            ['name' => 'From the Artist', 'ids' => [672, 207, 835, 861, 878, 925, 970, 1000, 1013, 1023, 1066, 547, 553, 557, 562, 570, 1073, 1098]]
        ];

        $videoCategories = [
            ['name' => 'Conservation', 'ids' => [158, 131, 124, 45]],
            ['name' => 'Collection', 'ids' => [162, 161, 131, 124, 118, 62, 32, 117, 113, 101, 111, 102, 92, 91, 87, 88, 66, 69, 68, 67, 45, 43, 34, 42, 40, 41, 39, 38, 29, 36, 35, 20, 19, 25, 31, 30, 28, 27, 26, 23, 22, 21, 7]],
            ['name' => 'Exhibitions', 'ids' => [155, 159, 152, 142, 138, 132, 114, 101, 82, 70, 44, 36, 35]],
            ['name' => 'Museum History', 'ids' => [146]],
            ['name' => 'Artists', 'ids' => [161, 138, 132]],
            ['name' => 'From the Curator', 'ids' => [161, 142, 45]],
            ['name' => 'Staff Picks', 'ids' => [92, 91, 87, 88, 43, 34, 42, 40, 41, 39, 38]],
            ['name' => 'Modern Art', 'ids' => [124, 32, 117, 25, 31]],
            ['name' => 'Contemporary Art', 'ids' => [155, 138, 113, 101, 102, 87, 82, 68, 67, 44, 42, 27]],
            ['name' => 'Arts of Asia', 'ids' => [155, 69, 26]],
            ['name' => 'Arts of the Americas', 'ids' => [161, 131, 118, 111, 45, 29, 20, 22, 21]],
            ['name' => 'Arts of Ancient Greek, Roman, and Byzantine Worlds', 'ids' => [62, 87, 7]],
            ['name' => 'Arts of Africa', 'ids' => [162, 114, 23]],
            ['name' => 'Textiles', 'ids' => [132, 68, 44]],
            ['name' => 'Photography and Media', 'ids' => [41]],
            ['name' => 'European Painting and Sculpture', 'ids' => [158, 152, 91, 43, 34, 38, 36, 35, 19, 30, 28]],
            ['name' => 'Medieval and Renaissance', 'ids' => [38]],
            ['name' => 'European Design, pre-1900', 'ids' => []],
            ['name' => 'Architecture and Design', 'ids' => [39]],
            ['name' => 'Impressionism', 'ids' => [36, 35, 19, 30, 28]],
            ['name' => 'Surrealism', 'ids' => [124]],
            ['name' => 'Ancient Art', 'ids' => [62, 88, 7]],
            ['name' => 'Thorne Miniature Rooms', 'ids' => [92]],
            ['name' => 'Chicago', 'ids' => [146, 131, 102, 20, 25]],
            ['name' => 'From the Artist', 'ids' => [138, 132, 113, 101, 44]]
        ];

        // This is a list of video ID's that are opt-in for listings

        $videoOptIn = [
            162, 161, 158, 155, 159, 152, 146, 142, 138, 132, 131, 124, 118, 62, 32, 117, 114, 113, 101, 111, 102, 95, 92, 91, 87, 88, 82, 55, 66, 70, 71, 69, 68, 67, 45, 44, 43, 42, 40, 41, 39, 38, 29, 36, 35, 20, 19, 25, 31, 30, 28, 27, 26, 23, 22, 21, 7
        ];

        $highlightsCategories = [
            ['name' => 'Exhibitions.1', 'ids' => [44, 31, 58]],
            ['name' => 'Modern Art', 'ids' => [38, 9, 48, 45, 60, 55, 53, 13, 63, 3, 67, 65]],
            ['name' => 'Contemporary Art', 'ids' => [38, 28, 48, 45, 44, 36, 31, 64, 60, 56, 55, 54, 63, 51, 3, 65, 37, 35, 33, 29]],
            ['name' => 'Arts of Asia', 'ids' => [42, 38, 28, 22, 21, 49, 45, 64, 56, 55, 53, 50, 63, 51, 3, 65, 37]],
            ['name' => 'Arts of the Americas', 'ids' => [38, 10, 6, 49, 45, 36, 64, 60, 56, 55, 54, 53, 50, 41, 63, 51, 3, 67, 65, 37, 35, 33]],
            ['name' => 'Arts of Ancient Greek, Roman, and Byzantine Worlds', 'ids' => [46, 45, 19, 64, 55, 53, 67, 35]],
            ['name' => 'Arts of Africa', 'ids' => [45, 60, 55, 54, 53, 51, 67, 35]],
            ['name' => 'Textiles', 'ids' => [45, 31, 55, 41, 63, 35, 33, 29]],
            ['name' => 'Photography and Media', 'ids' => [38, 28, 49, 45, 55, 54, 33, 29]],
            ['name' => 'European Painting and Sculpture', 'ids' => [48, 45, 36, 5, 58, 56, 55, 63, 51, 3, 35]],
            ['name' => 'Prints and Drawings', 'ids' => [55, 35, 33, 29]],
            ['name' => 'Medieval and Renaissance', 'ids' => [56]],
            ['name' => 'European Design, pre-1900', 'ids' => [45]],
            ['name' => 'Architecture and Design', 'ids' => [38, 49, 45, 64, 55, 63, 35, 33, 29]],
            ['name' => 'Impressionism', 'ids' => [5, 58, 3]],
            ['name' => 'Surrealism', 'ids' => [13]],
            ['name' => 'Arms and Armor', 'ids' => [56, 53, 51, 3]],
            ['name' => 'Japanese Prints', 'ids' => [42]],
            ['name' => 'Ancient Art', 'ids' => [46, 45, 19, 60, 53, 50]],
            ['name' => 'Thorne Miniature Rooms', 'ids' => [12, 51]],
            ['name' => 'Chicago', 'ids' => [38, 27, 12, 64]],
            ['name' => 'New Acquisition', 'ids' => [45, 55, 4]],
            ['name' => 'From the Artist', 'ids' => [31]]
        ];

        $interactiveFeatureCategories = [
            ['name' => 'Conservation.1', 'ids' => [1097, 1087, 631, 1076, 1046]],
            ['name' => 'Modern Art', 'ids' => [664, 1087]],
            ['name' => 'Contemporary Art', 'ids' => [1057, 1053, 928]],
            ['name' => 'Arts of Asia', 'ids' => [631, 1068]],
            ['name' => 'Arts of the Americas', 'ids' => [1087, 850, 710, 998, 1073, 1057, 1053, 1046, 1035, 1018, 807, 841, 1033]],
            ['name' => 'Arts of Ancient Greek, Roman, and Byzantine Worlds', 'ids' => [1097, 1083, 1090, 1088, 1066, 813]],
            ['name' => 'Arts of Africa', 'ids' => [1098, 1076, 1092, 1094, 1072, 1077, 1061, 1052, 1050, 740, 1045]],
            ['name' => 'Textiles', 'ids' => [841]],
            ['name' => 'Photography and Media', 'ids' => [1062, 1049, 899]],
            ['name' => 'European Painting and Sculpture', 'ids' => [676, 963, 1048, 1067, 1054]],
            ['name' => 'Prints and Drawings', 'ids' => [1087, 1071, 1051, 740, 807, 928]],
            ['name' => 'Medieval and Renaissance', 'ids' => [1093, 1090, 963, 1069, 1070, 1048, 1060]],
            ['name' => 'European Design, pre-1900', 'ids' => [963, 1069, 1058, 1073, 901]],
            ['name' => 'Surrealism', 'ids' => [664]],
            ['name' => 'Arms and Armor', 'ids' => [1093, 1070, 1060]],
            ['name' => 'Ancient Art', 'ids' => [1097, 1083, 1076, 1090, 1088, 1066, 1077, 1052, 1050, 813, 1018, 1045]],
            ['name' => 'Chicago', 'ids' => [1088]],
            ['name' => 'New Acquisition', 'ids' => [850, 676]],
        ];


        // Map article ID's to new categories

        foreach ($articleCategories as $category) {
            if (DB::table('categories')->where('name', $category['name'])->exists()) {
                $categoryId = DB::table('categories')->where('name', $category['name'])->value('id');

                foreach ($category['ids'] as $articleId) {
                    if (
                        DB::table('article_category')->where('article_id', $articleId)->where('category_id', $categoryId)->doesntExist() &&
                        DB::table('articles')->where('id', $articleId)->exists()
                    ) {
                        DB::table('article_category')->insert([
                        'article_id' => $articleId,
                        'category_id' => $categoryId,
                        ]);
                    }
                }
            }
        }

        // Map highlight ID's to new categories

        foreach ($highlightsCategories as $category) {
            if (DB::table('categories')->where('name', $category['name'])->exists()) {
                $categoryId = DB::table('categories')->where('name', $category['name'])->value('id');

                foreach ($category['ids'] as $highlightId) {
                    if (
                        DB::table('highlight_category')->where('highlight_id', $highlightId)->where('category_id', $categoryId)->doesntExist() &&
                        DB::table('highlights')->where('id', $highlightId)->exists()
                    ) {
                        DB::table('highlight_category')->insert([
                        'highlight_id' => $highlightId,
                        'category_id' => $categoryId,
                        ]);
                    }
                }
            }
        }

        // Map video ID's to new categories

        foreach ($videoCategories as $category) {
            if (DB::table('categories')->where('name', $category['name'])->exists()) {
                $categoryId = DB::table('categories')->where('name', $category['name'])->value('id');

                foreach ($category['ids'] as $videoId) {
                    if (
                        DB::table('video_category')->where('video_id', $videoId)->where('category_id', $categoryId)->doesntExist() &&
                        DB::table('videos')->where('id', $videoId)->exists()
                    ) {
                        DB::table('video_category')->insert([
                        'video_id' => $videoId,
                        'category_id' => $categoryId,
                        ]);
                    }
                }
            }
        }

        // Map video ID's to opt-in

        foreach ($videoOptIn as $videoId) {
            if (DB::table('videos')->where('id', $videoId)->exists()) {
                DB::table('videos')
                    ->where('id', $videoId)
                    ->update(['is_listed' => true]);
            }
        }

        // Map interactive feature ID's to new categories

        foreach ($interactiveFeatureCategories as $category) {
            if (DB::table('categories')->where('name', $category['name'])->exists()) {
                $categoryId = DB::table('categories')->where('name', $category['name'])->value('id');

                foreach ($category['ids'] as $experienceId) {
                    if (
                        DB::table('experience_category')->where('experience_id', $experienceId)->where('category_id', $categoryId)->doesntExist() &&
                        DB::table('experiences')->where('id', $experienceId)->exists()
                    ) {
                        DB::table('interactive_feature_category')->insert([
                        'interactive_feature_id' => $experienceId,
                        'category_id' => $categoryId,
                        ]);
                    }
                }
            }
        }
    }

    public function down(): void
    {
    }
};
