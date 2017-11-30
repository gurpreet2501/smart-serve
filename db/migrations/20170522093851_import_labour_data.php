<?php

use Phinx\Migration\AbstractMigration;

class ImportLabourData extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
       $partes = [
            ['name' => 'Pathrala'], 
            ['name' => 'Samanta'],
            ['name' => 'Rajendra'],
            ['name' => 'Chatni'],
            ['name' => 'Rafu'],
        ];

        $resp = $this->table('labour_partes')->insert($partes)->save();
        

        $categories = [
            ['name' => 'Paddy Unload'],
            ['name' => 'Paddy Issue'],
            ['name' => 'Rice Load 50kgs'],
            ['name' => 'Finished Product Recipt'],
            ['name' => 'Bags chatni'],
            ['name' => 'Rafu Work'],
            ['name' => 'Rice Load 20-25 kgs'],
            ['name' => 'Bran, Broken etc. load'],
            ['name' => 'Rice bag movement'],
        ];

        $resp = $this->table('labour_job_categories')->insert($categories)->save();

        $data = [
            ['name' => 'Direct Katai',
            'labour_party_id'    => 1,
            'labour_job_category' => 1,
            'rate' => 2.1,
            'job_description' =>' Unload from truck & direct katai in chalna'],
            ['name' => 'Thapi',
            'labour_party_id'    =>1,
            'labour_job_category' =>1,
            'rate' =>2.3,
            'job_description' =>'Unload from truck & thapi in the Godown.'],
            ['name' => 'Thapi 25+',
            'labour_party_id'    =>1,
            'labour_job_category' =>1,
            'rate' =>2.35,
            'job_description' =>'Unload from truck & thapi above 25 height in Godown'],
            ['name' => 'Godown Katai',
            'labour_party_id'    =>1,
            'labour_job_category' =>2,
            'rate' =>2.1,
            'job_description' =>'Paddy issued from any Godown near the plant'],
            ['name' => 'Katai G5-P1',
            'labour_party_id'    =>1,
            'labour_job_category' =>2,
            'rate' =>3.5,
            'job_description' =>'Paddy issue from Godown-5 in Plant-3 to Plant-1'],
            ['name' => 'Katai P3-P1',
            'labour_party_id'    =>1,
            'labour_job_category' =>2,
            'rate' =>2.6,
            'job_description' =>'Unload from Truck in Plant-3 & Katai to Plant-1'],
            ['name' => 'Katai P1-P3',
            'labour_party_id'    =>1,
            'labour_job_category' =>2,
            'rate' =>2.6,
            'job_description' =>'Unload from Truck in Plant-1 & Katai to Plant-3'],
            ['name' => 'Katai G2-P1',
            'labour_party_id'    =>1,
            'labour_job_category' =>2,
            'rate' =>2.3,
            'job_description' =>'Paddy issue from Godown-2 to Plant-I'],
            ['name' => 'Katai G3-P1',
            'labour_party_id'    =>1,
            'labour_job_category' =>2,
            'rate' =>2.5,
            'job_description' =>'Paddy issue from Godown-3 to Plant-I'],
            ['name' => 'Katai G3-P3',
            'labour_party_id'    =>1,
            'labour_job_category' =>2,
            'rate' =>2.2,
            'job_description' =>'Paddy issue from Godown-3 to Plant-3'],
            ['name' => 'Katai G2-P3',
            'labour_party_id'    =>1,
            'labour_job_category' =>2,
            'rate' =>2.3,
            'job_description' =>'Paddy issue from Godown-2 to Plant-3'],
            ['name' => 'Load-Unload',
            'labour_party_id'    =>1,
            'labour_job_category' =>2,
            'rate' =>4.2,
            'job_description' =>'Paddy is loaded in truck & unloaded in other plant'],
            ['name' => 'Return Paddy',
            'labour_party_id'    =>1,
            'labour_job_category' =>1,
            'rate' =>5,
            'job_description' =>'Paddy is unloaded from truck, but loaded back & returned to party.'],
            ['name' => 'Bundle Load',
            'labour_party_id'    =>1,
            'labour_job_category' =>1,
            'rate' =>2.1,
            'job_description' =>'Gunny bags bundles are loaded or unloaded'],
            ['name' => 'Chatni',
            'labour_party_id'    =>4,
            'labour_job_category' =>5,
            'rate' =>0.15,
            'job_description' =>'Gunny bags are cleaned & categorized.'],
            ['name' => 'Rafu',
            'labour_party_id'    =>5,
            'labour_job_category' =>6,
            'rate' =>0.62,
            'job_description' =>'Small rafu job is done in the pkts/bags'],
            ['name' => 'Tali',
            'labour_party_id'    =>5,
            'labour_job_category' =>6,
            'rate' =>1,
            'job_description' =>'Tali is attached to a bag/pkt'],
            ['name' => 'Bran Tali',
            'labour_party_id'    =>5,
            'labour_job_category' =>6,
            'rate' =>3,
            'job_description' =>'Two bags are attached to make big bran tali bags'],
            ['name' => 'PP Tali',
            'labour_party_id'    =>5,
            'labour_job_category' =>6,
            'rate' =>2,
            'job_description' =>'Two PP bags are attached to make big tali bags for broken etc.'],
            ['name' => 'Rice Direct Load 50kgs',
            'labour_party_id'    =>3,
            'labour_job_category' =>3,
            'rate' =>4.1,
            'job_description' =>'Rice filling, weighing, stitching & direct load to truck.'],
            ['name' => 'Rice Thapi Load 50kgs',
            'labour_party_id'    =>3,
            'labour_job_category' =>3,
            'rate' =>1.25,
            'job_description' =>'Rcie loading from thapi'],
            ['name' => 'Rice Thapi 50kgs',
            'labour_party_id'    =>3,
            'labour_job_category' =>4,
            'rate' =>2.85,
            'job_description' =>'Rice filling, weighing, stitching & thapi in Godown.'],
            ['name' => 'Rice Thapi Kacchi 50kgs',
            'labour_party_id'    =>3,
            'labour_job_category' =>4,
            'rate' =>3.1,
            'job_description' =>'Rice filling  stitching & thapi in Godown (without weighing)'],
            ['name' => 'Rice Direct Load 25kgs',
            'labour_party_id'    =>3,
            'labour_job_category' =>7,
            'rate' =>2.25,
            'job_description' =>'Rice filling, weighing, stitching & direct load to truck.'],
            ['name' => 'Rice Thapi Load 25kgs',
            'labour_party_id'    =>3,
            'labour_job_category' =>7,
            'rate' =>2.25,
            'job_description' =>'Rcie loading from thapi'],
            ['name' => 'Rice Thapi 25kgs',
            'labour_party_id'    =>3,
            'labour_job_category' =>4,
            'rate' =>0.85,
            'job_description' =>'Rice filling, weighing, stitching & thapi in Godown.'],
            ['name' => 'Rice Thapi Kacchi 25kgs',
            'labour_party_id'    =>3,
            'labour_job_category' =>4,
            'rate' =>1.25,
            'job_description' =>'Rice filling, stitching & thapi in Godown (without weighing)'],
            ['name' => 'Rice Direct Load 20kgs',
            'labour_party_id'    =>3,
            'labour_job_category' =>7,
            'rate' =>2.15,
            'job_description' =>'Rice filling, weighing, stitching & direct load to truck.'],
            ['name' => 'Rice Thapi Load 20kgs',
            'labour_party_id'    =>3,
            'labour_job_category' =>7,
            'rate' =>2.15,
            'job_description' =>'Rcie loading from thapi'],
            ['name' => 'Rice Thapi 20kgs',
            'labour_party_id'    => 3,
            'labour_job_category' => 4,
            'rate' => 0.85,
            'job_description' =>'Rice filling, weighing, stitching & thapi in Godown.'],
            ['name' => 'Bran Thapi',
            'labour_party_id'    =>3,
            'labour_job_category' =>4,
            'rate' =>1.25,
            'job_description' =>'Bran filling & thapi in the plant.'],
            ['name' => 'Broken Thapi',
            'labour_party_id'    =>3,
            'labour_job_category' =>4,
            'rate' =>1.25,
            'job_description' =>'Broken filling & thapi in the plant.'],
            ['name' => 'Rejection Thapi',
            'labour_party_id'    =>3,
            'labour_job_category' =>4,
            'rate' =>1.25,
            'job_description' =>'Rejection filling & thapi in the plant.'],
            ['name' => 'Mota Kunda Thapi',
            'labour_party_id'    =>3,
            'labour_job_category' =>4,
            'rate' =>1.25,
            'job_description' =>'Bran filling & thapi in the plant.'],
            ['name' => 'Bran Load',
            'labour_party_id'    =>3,
            'labour_job_category' =>8,
            'rate' =>3.1,
            'job_description' =>'Bran loading from Thapi or direct after filling.'],
            ['name' => 'Broken Load',
            'labour_party_id'    =>3,
            'labour_job_category' =>8,
            'rate' =>3.1,
            'job_description' =>'Broken loading from Thapi or direct after filling.'],
            ['name' => 'Rejection Load',
            'labour_party_id'    =>3,
            'labour_job_category' =>8,
            'rate' =>3.1,
            'job_description' =>'Rejection loading from Thapi or direct after filling.'],
            ['name' => 'Mota Kunda Load',
            'labour_party_id'    =>3,
            'labour_job_category' =>8,
            'rate' =>3.1,
            'job_description' =>'Mota Kunda loading from Thapi or direct after filling.'],
            ['name' => 'Mota Kunda Move',
            'labour_party_id'    =>3,
            'labour_job_category' =>4,
            'rate' =>2.5,
            'job_description' =>'Mota Kunda movement from one plant to other.'],
            ['name' => 'NBT Unload',
            'labour_party_id'    => 3,
            'labour_job_category' => 9,
            'rate' => 30,
            'job_description' =>'Unload of NBT bags bundles'],
        ];

        foreach ($data as $item) 
        {
            $resp = $this->table('labour_accounts')->insert([
                'job_title' => $item['name'],
                'job_description' => $item['job_description'],
                'labour_job_category_id' => $item['labour_job_category'],
                'created_at' => date('Y-m-d H:i:s')
            ])->save();

            $resp = $this->table('labour_party_job_rates')->insert([
                'labour_account_id' => $this->getAdapter()->getConnection()->lastInsertId(),
                'labour_party_id' => $item['labour_party_id'],
                'rate' =>  $item['rate']
            ])->save();
          }
    }
}
