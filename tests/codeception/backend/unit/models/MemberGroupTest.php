<?php
/**
 * User: Aleksey Stetsenko
 * Date: 11/28/18
 * Time: 9:26 PM
 */

namespace codeception\backend\unit\models;

use backend\models\MemberGroup;
use tests\codeception\common\unit\DbTestCase;

class MemberGroupTest extends DbTestCase
{

    /**
     * @test
     * @group MemberGroup
     *
     * @return MemberGroup
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function createMemberGroup()
    {
        $model = MemberGroup::createEmptyRow();

        $this->assertNotNull($model);
        $this->assertInstanceOf(MemberGroup::class, $model);
        $this->assertInternalType('integer', $model->id);

        return $model;
    }

    /**
     * @test
     * @group MemberGroup
     * @depends createMemberGroup
     *
     * @param MemberGroup $model
     */
    public function activateMemberGroup(MemberGroup $model)
    {
        $this->assertEquals($model->positive_creation, MemberGroup::ENABLED_NO);

        $this->assertTrue($model->activate());

        $this->assertEquals($model->positive_creation, MemberGroup::ENABLED_YES);
    }
}
