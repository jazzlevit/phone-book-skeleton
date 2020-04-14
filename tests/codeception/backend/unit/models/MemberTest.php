<?php
/**
 * User: Aleksey Stetsenko
 * Date: 11/21/18
 * Time: 8:12 PM
 */

namespace codeception\backend\unit\models;

use backend\models\Member;
use backend\models\MemberAddress;
use tests\codeception\common\unit\DbTestCase;

class MemberTest extends DbTestCase
{

    /**
     * TODO TearsDown
     */
    protected function setUp()
    {
        parent::setUp();

        MemberAddress::deleteAll();
        Member::deleteAll();
    }

    /**
     * @test
     * @group Member
     *
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function createMember()
    {
        $model = Member::createEmptyRow();

        $this->assertNotNull($model);
        $this->assertInstanceOf(Member::class, $model);
        $this->assertInternalType('integer', $model->id);

        $this->assertNotNull($model->address);
        $this->assertInstanceOf(MemberAddress::class, $model->address);
        $this->assertInternalType('integer', $model->address->id);

        return $model;
    }

    /**
     * @test
     * @group Member
     * @depends createMember
     * @param Member $model
     * @return Member
     */
    public function activateMember(Member $model)
    {
        $this->assertEquals($model->positive_creation, Member::ENABLED_NO);

        $this->assertTrue($model->activate());

        $this->assertEquals($model->positive_creation, Member::ENABLED_YES);

        return $model;
    }

    /**
     * @test
     * @group Member
     * @depends createMember
     *
     * @param Member $model
     * @return Member
     */
    public function pauseMember(Member $model)
    {
        $this->assertFalse($model->getIsPaused());

        $model->pause();

        $this->assertTrue($model->getIsPaused());

        return $model;
    }

    /**
     * @test
     * @group Member
     * @depends pauseMember
     *
     * @param Member $model
     */
    public function restoreMember(Member $model)
    {
        $this->assertTrue($model->getIsPaused());

        $model->restore();

        $this->assertFalse($model->getIsPaused());
    }

    /**
     * @test
     * @group Member
     */
    public function checkServeTypeFullOptionIsUnique()
    {
        $serveTypes = Member::getServeTypeFullOption();

        $this->assertInternalType('array', $serveTypes);

        $this->assertCount(count(array_unique($serveTypes)), $serveTypes);
    }
}
