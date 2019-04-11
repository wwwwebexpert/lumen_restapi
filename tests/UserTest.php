<?php

class UserTest extends TestCase
{
    /**
     * /api/users [GET]
     */
    public function testShouldReturnAllUsers(){
        $this->get("/api/users", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['*' =>
                [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
                ]
            ]);
        
    }

    /**
     * /api/users [POST]
     */
    public function testShouldCreateUser(){
        $parameters = [
            'name' => 'Aman',
            'email' => 'www.webexpert@gmail.com',
        ];
        $this->post("/api/users", $parameters, []);
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
        ]);
        
    }
    
    /**
     * /api/users/id [PUT]
     */
    public function testShouldUpdateUser(){
        $parameters = [
            'name' => 'Aman Thakur'
        ];
        $this->put("/api/users/6", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at'
        ]);
    }
    /**
     * /api/users/id [DELETE]
     */
    public function testShouldDeleteUser(){
        
        $this->delete("/api/users/6", [], []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
                'message'
        ]);
    }

    /**
     * /api/users/assignUserToTeams/id [PUT]
     */
    public function testShouldUpdateAssignUserToTeams(){
        $parameters = [
            'teams' => '1,2'
        ];
        $this->put("/api/users/assignUserToTeams/1", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
                    'message'
        ]);
    }

    /**
     * /api/users/assignRole/id [PUT]
     */
    public function testShouldUpdateAssignRoleToUser(){
        $parameters = [
            'role_id' => '1'
        ];
        $this->put("/api/users/assignRole/1", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
                    'message'
        ]);
    }

    /**
     * /api/users/getUserTeams/id [GET]
     */
    public function testShouldUpdateGetUserTeams(){
        
        $this->get("/api/users/getUserTeams/1", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(['*' =>
                [
                    'id',
                    'name',
                    'title',
                     
                ]
            ]);
        
    }

      
}