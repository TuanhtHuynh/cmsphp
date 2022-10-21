<?php
declare ( strict_types = 1 );

use modules\page\models\Page;
use PHPUnit\Framework\TestCase;

require_once 'src/Entity.php';
require_once 'modules/page/models/Page.php';

class Fake
{
    public function execute()
    {}
    public function fetchAll()
    {
        return [
            [
                'id' => 12, 'title' => 'fake title', 'content' => 'fake content',
            ],
            [
                'id' => 133, 'title' => 'fake title 133', 'content' => 'fake content 133',
            ],
        ];
    }
}

class FakeDConnection
{
    public function prepare()
    {
        return new Fake();
    }
}

final class RecordTest extends TestCase
{
    public function testFindAll(): void
    {
        $dbc = new FakeDConnection();
        $page = new Page( $dbc );
        $result = $page->findAll();

        $this->assertEquals( 2, count( $result ) );
    }

    public function testFindBy(): void
    {
        $dbc = new FakeDConnection();
        $page = new Page( $dbc );
        $page->findBy( 'id', 12 );

        $this->assertEquals( 12, $page->id );
    }

    public function testSave(): void
    {
        $mockdb = $this->getMockBuilder( FakeDConnection::class )
            ->enableProxyingToOriginalMethods()
            ->getMock();

        $mockdb->expects( $this->exactly( 2 ) )
            ->method( 'prepare' )
            ->with(
                $this->logicalOr(
                    $this->equalTo( 'SELECT * FROM pages WHERE id = :value' ),
                    $this->equalTo( 'UPDATE pages SET title = :title, content = :content WHERE id = :id' )
                )
            );

        $page = new Page( $mockdb );
        $page->findBy( 'id', 12 );

        $page->title = 'trang chu';
        $page->save();

        $this->assertEquals( 'trang chu', $page->title );

    }
}