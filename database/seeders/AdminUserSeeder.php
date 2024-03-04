<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            //me
            ['name' => 'Ash', 'email' => 'admin@ash'],
            ['name' => '真冬', 'email' => 'admin@mafuyu'],
            ['name' => 'ライム', 'email' => 'admin@raimu'],
            ['name' => 'まめひなた', 'email' => 'admin@mamehinata'],
            ['name' => 'ホノカ', 'email' => 'admin@honoka'],
            ['name' => 'シエル', 'email' => 'admin@ciel'],
            ['name' => 'トラス', 'email' => 'admin@truss'],
            ['name' => '透羽', 'email' => 'admin@sue'],
            ['name' => 'ソフィナ', 'email' => 'admin@sophina'],
            ['name' => 'ルフカ', 'email' => 'admin@rufuka'],
            ['name' => 'Shaclo', 'email' => 'admin@shaclo'],

            //frend
            ['name' => 'マヌカ', 'email' => 'admin@manuka'],
            ['name' => 'リーファ', 'email' => 'admin@leafa'],
            ['name' => '桔梗', 'email' => 'admin@kikyo'],
            ['name' => 'サフィー', 'email' => 'admin@safie'],
            ['name' => 'ミルク', 'email' => 'admin@milk'],
            ['name' => 'ラスク', 'email' => 'admin@rusk'],
            ['name' => 'カリン', 'email' => 'admin@karin'],
            ['name' => 'セレスティア', 'email' => 'admin@celestia'],
            ['name' => 'ウルフェリア', 'email' => 'admin@ulferia'],
            ['name' => 'あのん', 'email' => 'admin@anon'],
            ['name' => 'カルキア', 'email' => 'admin@kalkia'],
            ['name' => 'シフォン', 'email' => 'admin@chiffon'],
            ['name' => 'デルタフレア', 'email' => 'admin@deltaflare'],
            ['name' => 'セフィラ', 'email' => 'admin@sephira'],
            ['name' => 'メイユン', 'email' => 'admin@meiyun'],
            ['name' => 'イナバ', 'email' => 'admin@inaba'],
            ['name' => '舞夜', 'email' => 'admin@maiya'],
            ['name' => '萌', 'email' => 'admin@moe'],
            ['name' => 'ゾメ', 'email' => 'admin@zome'],
            ['name' => '竜胆', 'email' => 'admin@rindou'],
            ['name' => '薄荷', 'email' => 'admin@hakka'],
            ['name' => 'ナユ', 'email' => 'admin@nayu'],
            ['name' => 'サイバーキャット', 'email' => 'admin@cybercat'],
            ['name' => 'メリノ', 'email' => 'admin@merino'],
            ['name' => 'ミント', 'email' => 'admin@mint'],
            ['name' => 'プラチナ', 'email' => 'admin@platinum'],
            ['name' => 'フィオナ', 'email' => 'admin@fiona'],
            ['name' => 'Grus', 'email' => 'admin@grus'],
            ['name' => 'リアアリス', 'email' => 'admin@rearice'],
            ['name' => '瑞希', 'email' => 'admin@mizuki'],
            ['name' => 'ソラハ', 'email' => 'admin@soraha'],
            ['name' => 'Emmelie', 'email' => 'admin@emmelie'],
        ];

        $firstTeamId = null;

        foreach ($users as $index => $userData) {
            $user = User::factory()->create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // 実際にはHash::makeなどを使う
            ]);

            if ($index === 0) {
                // 最初のユーザー（Ash）のみチームを作成
                $team = Team::factory()->create([
                    'user_id' => $user->id,
                    'name' => "運営",
                    'personal_team' => true,
                ]);
                $user->current_team_id = $team->id;
                $user->save();

                $firstTeamId = $team->id;
            } else {
                // 最初に作成したチームに所属させる
                $user->current_team_id = $firstTeamId;
                $user->save();
            }
        }
    }
}
