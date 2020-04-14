<?php

use tests\codeception\backend\FunctionalTester;
use tests\codeception\common\_pages\MemberGroupPage;
use tests\codeception\common\_pages\MembersPage;
use tests\codeception\common\_pages\MembersPausedPage;

/* @var $scenario Codeception\Scenario */

$I = new FunctionalTester($scenario);
$I->wantTo('ensure guest has no access to important pages');

$I->amGoingTo('check that "member page" is protected for guest');
$page = MembersPage::openBy($I);
$I->seeInCurrentUrl(urlencode('site/login'));
$I->see('Sign In');
$I->dontSee('Sign out');

$I = new FunctionalTester($scenario);
$I->amGoingTo('check that "member group page" is protected for guest');
$page = MemberGroupPage::openBy($I);
$I->seeInCurrentUrl(urlencode('site/login'));
$I->see('Sign In');
$I->dontSee('Sign out');

$I = new FunctionalTester($scenario);
$I->amGoingTo('check that "member paused page" is protected for guest');
$page = MembersPausedPage::openBy($I);
$I->seeInCurrentUrl(urlencode('site/login'));
$I->see('Sign In');
$I->dontSee('Sign out');

$I = new FunctionalTester($scenario);
$I->amGoingTo('check that guest user must be redirected to site/login even on error)');
$I->amOnRoute('site/not-existed-url');
$I->seeInCurrentUrl(urlencode('site/login'));
$I->see('Sign In');
$I->dontSee('Sign out');
