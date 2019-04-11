<?php

class TeamTest extends TestCase
{
    /**
     * /api/teams [GET]
     */
    public function testShouldReturnAllTeams(){
        $this->get("/api/teams", []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure(
            ['*' =>
                [
                    'id',
                    'title',
                    'created_at',
                    'updated_at',
                    'owner'
                ]
            ]);
        
    }

    /**
     * /api/teams [POST]
     */
    public function testShouldCreateTeam(){
        $parameters = [
            'title' => 'Laravel Team',  
        ];
        $this->post("/api/teams", $parameters, []);
        $this->seeStatusCode(201);
        $this->seeJsonStructure([
                     'id',
                    'title',
                    'created_at',
                    'updated_at'
        ]);
        
    }
    
    /**
     * /api/teams/id [PUT]
     */
    public function testShouldUpdateTeam(){
        $parameters = [
            'title' => 'Laravel Teams',  
        ];
        $this->put("/api/teams/1", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
                     'id',
                    'title',
                    'created_at',
                    'updated_at'
        ]);
    }
    /**
     * /api/teams/id [DELETE]
     */
    public function testShouldDeleteTeam(){
        
        $this->delete("/api/teams/1", [], []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
                'message'
        ]);
    }

     /**
     * /api/teams/assignOwner/id [PUT]
     */
    public function testShouldAssignOwner(){
        $parameters = [
            'owner' => '1'  
        ];
        $this->put("/api/teams/assignOwner/1", $parameters, []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
                   'message'
                   
        ]);
    }
}