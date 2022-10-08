<?php
use Migrations\AbstractMigration;

class CreateRequestStats extends AbstractMigration
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
        $table = $this->table('requeststats');
        $table->addColumn('user_id', 'integer', ['default' => null, 'null' => false,])
            ->addColumn('rq_user_id', 'integer', ['default' => null, 'null' => false,])
            ->addColumn('is_matched', 'integer', ['default' => null, 'null' => false,])
            ->addColumn('rq_state', 'integer', ['default' => null, 'null' => false,])
            ->addColumn('rq_date', 'datetime', ['default' => null, 'null' => false,])
            ->create();
    }

    public function down()
    {
        $this->dropTable('requeststats');
    }
}
