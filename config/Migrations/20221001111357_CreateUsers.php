<?php

use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function up()
    {
        $table = $this->table('users')
            ->addColumn('user_name', 'text', ['default' => null, 'null' => false,])
            ->addColumn('email', 'text', ['default' => null, 'limit' => 255, 'null' => false,])
            ->addColumn('pass', 'text', ['default' => null, 'limit' => 50, 'null' => false,])
            ->addColumn('passfor', 'text', ['default' => null, 'limit' => 255, 'null' => false,])
            ->addColumn('pf_img', 'text', ['default' => null, 'limit' => 255, 'null' => true,])
            ->addColumn('pf_head', 'text', ['default' => null, 'limit' => 255, 'null' => true,])
            ->addColumn('pubg_flg', 'integer', ['default' => null,'null' => true,])
            ->addColumn('lol_flg', 'integer', ['default' => null, 'null' => true,])
            ->addColumn('pubg_name', 'text', ['default' => null, 'limit' => 50, 'null' => true,])
            ->addColumn('lol_name', 'text', ['default' => null, 'limit' => 50, 'null' => true,])
            ->addColumn('pubg_id', 'text', ['default' => null, 'limit' => 30, 'null' => true,])
            ->addColumn('pubg_seasonid', 'text', ['default' => null, 'limit' => 30, 'null' => true,])
            ->addColumn('pubg_solorank', 'text', ['default' => null, 'limit' => 30, 'null' => true,])
            ->addColumn('pubg_duorank', 'text', ['default' => null, 'limit' => 30, 'null' => true,])
            ->addColumn('pubg_squadrank', 'text', ['default' => null, 'limit' => 30, 'null' => true,])
            ->addColumn('pubg_solokd', 'float', ['default' => null,'null' => true,])
            ->addColumn('pubg_duokd', 'float', ['default' => null, 'null' => true,])
            ->addColumn('pubg_squadkd', 'float', ['default' => null, 'null' => true,])
            ->addColumn('pubg_solopoints', 'integer', ['default' => null, 'null' => true,])
            ->addColumn('pubg_duopoints', 'integer', ['default' => null, 'null' => true,])
            ->addColumn('pubg_squadpoints', 'integer', ['default' => null, 'null' => true,])
            ->addColumn('lol_level', 'integer', ['default' => null, 'null' => true,])
            ->addColumn('lol_solorank', 'text', ['default' => null, 'limit' => 30, 'null' => true,])
            ->addColumn('lol_points', 'integer', ['default' => null, 'null' => true,])
            ->addColumn('lol_winrate', 'text', ['default' => null, 'limit' => 30, 'null' => true,])
            ->addColumn('intro', 'text', ['default' => null, 'limit' => 2000, 'null' => true,])
            ->addColumn('pubg_goal', 'text', ['default' => null, 'limit' => 50, 'null' => true,])
            ->addColumn('lol_goal', 'text', ['default' => null, 'limit' => 50, 'null' => true,])
            ->addColumn('team', 'text', ['default' => null, 'limit' => 50, 'null' => true,])
            ->addColumn('game_values', 'integer', ['default' => null, 'null' => false,])
            ->addColumn('tmt_flg', 'integer', ['default' => null, 'null' => false,])
            ->addColumn('discord', 'text', ['default' => null, 'limit' => 100, 'null' => true,])
            ->addColumn('skype', 'text', ['default' => null, 'limit' => 100, 'null' => true,])
            ->create();
    }

    public function down()
    {
        $this->dropTable('users');
    }
}
