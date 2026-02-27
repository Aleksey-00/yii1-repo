<?php

class m260226_200606_initial_schema extends CDbMigration
{
	public function safeUp()
	{
	    $this->createTable('author', array(
                'id' => 'pk',
                'fio' => 'string NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createTable('book', array(
                 'id' => 'pk',
                 'title' => 'string NOT NULL',
                 'year' => 'integer NOT NULL',
                 'description' => 'text',
                 'isbn' => 'string NOT NULL',
                 'image' => 'string',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

         $this->createTable('book_author', array(
                 'book_id' => 'integer NOT NULL',
                 'author_id' => 'integer NOT NULL',
                 'PRIMARY KEY (book_id, author_id)',
         ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

         $this->createTable('subscription', array(
                  'id' => 'pk',
                  'author_id' => 'integer NOT NULL',
                  'phone' => 'string NOT NULL',
         ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

         $this->addForeignKey(
             'fk_book_author_book',
             'book_author',
             'book_id',
             'book',
             'id',
             'CASCADE',
             'CASCADE'
         );
         $this->addForeignKey(
             'fk_book_author_author',
              'book_author',
              'author_id',
              'author',
              'id',
              'CASCADE',
              'CASCADE'
          );
         $this->addForeignKey(
             'fk_subscription_author',
             'subscription',
             'author_id',
             'author',
             'id',
             'CASCADE',
             'CASCADE'
         );
	}

	public function safeDown()
	{
	    $this->dropTable('subscription');
        $this->dropTable('book_author');
        $this->dropTable('book');
        $this->dropTable('author');
	}
}