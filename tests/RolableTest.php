<?php

namespace Bosnadev\Tests\Ronin;

use Bosnadev\Ronin\Models\Role;
use Bosnadev\Tests\Ronin\RoninTestCase as TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RolableTest extends TestCase
{
    protected $user;

    public function setUp()
    {
        parent::setUp();
    }

    public function testUserRoleRelationship()
    {
        $this->assertInstanceOf(BelongsToMany::class, $this->user->roles());
        $this->assertInstanceOf(Collection::class, $this->user->roles()->get());
    }

    public function testUserHasRole()
    {
        $this->user->assignRole(1);

        $this->refreshUserInstance();

        $role = Role::find(1);
        $this->assertTrue($this->user->hasRole('artisan'));
        $this->assertTrue($this->user->hasRole($role));
        $this->assertFalse($this->user->hasRole(1));
        $this->assertTrue($this->user->hasAnyRole(['artisan', 'artisans']));
        $this->assertTrue($this->user->hasAnyRole([$role, 'artisans']));
        $this->assertFalse($this->user->hasAnyRole(['artisans', 'editor']));
        $this->assertCount(1, $this->user->getRoles());
    }

    public function testIfUserHaveRoleWithAGivenSlug()
    {
        $this->user->assignRole(1);

        $this->refreshUserInstance();

        $role = Role::find(1);
        $this->assertTrue($this->user->userRoleSlug($role->slug));
    }

    public function testAssigningRoleWhenNoRoleProvided()
    {
        $role = $this->user->assignRole();
        $this->refreshUserInstance();

        $this->assertFalse($role);
    }
}