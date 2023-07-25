<?php
require_once 'DAO.php';

class Cart{
    public int $memberid;
    public string $goodscode;
    public string $goodsname;
    public int $price;
    public string $detail;
    public string $goodsimage;
    public int $num;
}

class CartDAO{
    public function get_cart_by_memberid(int $memberid){
        $dbh = DAO::get_db_connect();

        $sql = "SELECT memberid,Cart.goodscode,goodsname,price,detail,goodsimage,num 
                FROM Cart INNER JOIN Goods ON Cart.goodscode = Goods.goodscode
                WHERE memberid = :memberid  ";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(':memberid',$memberid,PDO::PARAM_INT);
        $stmt->execute();

        $data = [];
        while($row = $stmt->fetchObject('Cart')){
            $data[] = $row;
        }
        return $data;
    }

    public function cart_exists(int $memberid, string $goodscode){
        $dbh = DAO::get_db_connect();

        $sql = "select * from cart where memberid = :memberid and goodscode = :goodscode";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(':memberid',$memberid,PDO::PARAM_INT);
        $stmt->bindValue(':goodscode',$goodscode,PDO::PARAM_STR);

        $stmt->execute();

        if($stmt->fetch() !== false){
            return true;
        }
        else{
            return false;
        }
    }

    public function insert(int $memberid,string $goodscode,int $num){
        $dbh = DAO::get_db_connect();

        if(!$this->cart_exists($memberid,$goodscode)){
            $sql = "insert into cart (memberid , goodscode ,num) values (:memberid,:goodscode,:num)";

            $stmt = $dbh->prepare($sql);

            $stmt->bindValue(':memberid',$memberid,PDO::PARAM_INT);
            $stmt->bindValue(':goodscode',$goodscode,PDO::PARAM_STR);
            $stmt->bindValue(':num',$num,PDO::PARAM_INT);
            $stmt->execute();
        }else{
            $sql = "update cart set num = num + :num where memberid = :memberid and goodscode = :goodscode";

            $stmt = $dbh->prepare($sql);

            $stmt->bindValue(':num',$num,PDO::PARAM_INT);
            $stmt->bindValue(':memberid',$memberid,PDO::PARAM_INT);
            $stmt->bindValue(':goodscode',$goodscode,PDO::PARAM_STR);
            
            $stmt->execute();
        }
    }

    public function update(int $memberid,string $goodscode,int $num){
        $dbh = DAO::get_db_connect();

        $sql = "update cart 
                set num = :num 
                where memberid = :memberid and goodscode = :goodscode";

                $stmt = $dbh->prepare($sql);

                $stmt->bindValue(':memberid',$memberid,PDO::PARAM_INT);
                $stmt->bindValue(':goodscode',$goodscode,PDO::PARAM_STR);
                $stmt->bindValue(':num',$num,PDO::PARAM_INT);

                $stmt->execute();
    }

    public function delete(int $memberid,string $goodscode){
        $dbh = DAO::get_db_connect();

        $sql = "delete from cart 
                where memberid = :memberid and goodscode = :goodscode";
        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(':memberid',$memberid,PDO::PARAM_INT);
        $stmt->bindValue(':goodscode',$goodscode,PDO::PARAM_STR);

        $stmt->execute();

    }
    public function delete_by_memberid(int $memberid){
        $dbh = DAO::get_db_connect();

        $sql = "delete from Cart where memberid = :memberid";

        $stmt = $dbh->prepare($sql);

        $stmt->bindValue(':memberid',$memberid,PDO::PARAM_INT);

        $stmt->execute();
    }
        
        
    

}