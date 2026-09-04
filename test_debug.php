<?php
$str = file_get_contents('app/models/User_model.php');
$methodCode = <<<'CODE'
    public function updateFotoViaUser($id_user, $foto_baru) {
        $this->db->query("UPDATE mst_user SET photo_profil = :photo_profil WHERE id_user = :id_user");
        $this->db->bind(':photo_profil', $foto_baru);
        $this->db->bind(':id_user', $id_user);
        
        $this->db->execute();
        return $this->db->rowCount();
    }
CODE;
// Add before the last closing brace
$str = preg_replace('/}\s*$/', "\n$methodCode\n}", $str);
file_put_contents('app/models/User_model.php', $str);
