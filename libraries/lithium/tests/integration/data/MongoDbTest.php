<?php
/**
 * li₃: the most RAD framework for PHP (http://li3.me)
 *
 * Copyright 2016, Union of RAD. All rights reserved. This source
 * code is distributed under the terms of the BSD 3-Clause License.
 * The full license text can be found in the LICENSE.txt file.
 */

namespace lithium\tests\integration\data;

use MongoId;
use lithium\core\Libraries;
use lithium\data\Connections;
use lithium\data\model\Query;
use lithium\tests\fixture\model\mongodb\Images;
use lithium\tests\fixture\model\mongodb\Galleries;
use li3_fixtures\test\Fixtures;

class MongoDbTest extends \lithium\tests\integration\data\Base {

	protected $_export = null;

	protected $_fixtures = [
		'images' => 'lithium\tests\fixture\model\mongodb\ImagesFixture',
		'galleries' => 'lithium\tests\fixture\model\mongodb\GalleriesFixture',
	];

	public function skip() {
		parent::connect($this->_connection);
		if (!class_exists('li3_fixtures\test\Fixtures')) {
			$this->skipIf(true, 'Need `li3_fixtures` to run tests.');
		}
		$this->skipIf(!$this->with(['MongoDb']));
		$this->_export = Libraries::path('lithium\tests\fixture\model\mongodb\export', [
			'dirs' => true
		]);
	}

	/**
	 * Creating the test database
	 */
	public function setUp() {
		$options = [
			'db' => [
				'adapter' => 'Connection',
				'connection' => $this->_connection,
				'fixtures' => $this->_fixtures
			]
		];

		Fixtures::config($options);
		Fixtures::save('db');
	}

	/**
	 * Dropping the test database
	 */
	public function tearDown() {
		Fixtures::clear('db');
		Galleries::reset();
		Images::reset();
	}

	public function testInsert() {
		$image = Images::create(['title' => 'Post Title']);
		$this->assertIdentical(true, $image->save());
		$this->assertInstanceOf('MongoDB\BSON\ObjectID', $image->_id);

		$persisted = Images::first($image->_id);
		$this->assertEqual([
			'_id' => (string) $image->_id,
			'title' => 'Post Title'
		], $persisted->data());
	}

	public function testUpdate() {
		$image = Images::create(['title' => 'Post Title']);
		$this->assertIdentical(true, $image->save());

		$image->title = 'Updated Post Title';
		$this->assertIdentical(true, $image->save());

		$persisted = Images::first($image->_id);
		$this->assertEqual([
			'_id' => (string) $image->_id,
			'title' => 'Updated Post Title'
		], $persisted->data());
	}

	public function testDelete() {
		$image = Images::create(['title' => 'Post Title']);
		$this->assertIdentical(true, $image->save());
		$id = $image->_id;

		$count = Images::find('count', ['conditions' => ['_id' => $id]]);
		$this->assertIdentical(1, $count);

		$image->delete();

		$count = Images::find('count', ['conditions' => ['_id' => $id]]);
		$this->assertIdentical(0, $count);
	}

	public function testCount() {
		$count = Galleries::find('count');
		$this->assertIdentical(2, $count);
	}

	public function testSorting() {
		$asc = Galleries::find('all', ['order' => ['name']]);

		$this->assertEqual('Bar Gallery', $asc->first()->name);
		$this->assertEqual('Foo Gallery', $asc->next()->name);

		$desc = Galleries::find('all', ['order' => ['name' => 'desc']]);

		$this->assertEqual('Foo Gallery', $desc->first()->name);
		$this->assertEqual('Bar Gallery', $desc->next()->name);
	}

	public function testCountOnEmptyResultSet() {
		$data = Galleries::find('all', ['conditions' => ['name' => 'no match']]);

		$expected = 0;
		$result = $data->count();
		$this->assertIdentical($expected, $result);
	}

	public function testIterateOverEmptyResultSet() {
		$data = Galleries::find('all', ['conditions' => ['name' => 'no match']]);

		$result = next($data);
		$this->assertNull($result);
	}

	public function testDateCastingUsingExists() {
		Galleries::remove();
		Galleries::config(['schema' => ['_id' => 'id', 'created_at' => 'date']]);
		$gallery = Galleries::create(['created_at' => time()]);
		$gallery->save();

		$result = Galleries::first(['conditions' => ['created_at' => ['$exists' => false]]]);
		$this->assertNull($result);
	}

	public function testManyToOne() {
		$opts = ['conditions' => ['gallery' => 1]];

		$query = new Query($opts + [
			'type' => 'read',
			'model' => 'lithium\tests\fixture\model\mongodb\Images',
			'source' => 'images',
			'alias' => 'Images',
			'with' => ['Galleries']
		]);
		$images = $this->_db->read($query)->data();
		$expected = include $this->_export . '/testManyToOne.php';
		$this->assertEqual($expected, $images);

		$images = Images::find('all', $opts + ['with' => 'Galleries'])->data();
		$this->assertEqual($expected, $images);
	}

	public function testOneToMany() {
		$opts = ['conditions' => ['_id' => 1]];

		$query = new Query($opts + [
			'type' => 'read',
			'model' => 'lithium\tests\fixture\model\mongodb\Galleries',
			'source' => 'galleries',
			'alias' => 'Galleries',
			'with' => ['Images']
		]);
		$galleries = $this->_db->read($query)->data();
		$expected = include $this->_export . '/testOneToMany.php';
		$this->assertEqual($expected, $galleries);

		$gallery = Galleries::find('first', $opts + ['with' => 'Images'])->data();
		$this->assertEqual(3, count($gallery['images']));
		$this->assertEqual(reset($expected), $gallery);
	}

}

?>