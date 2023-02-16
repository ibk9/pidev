/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Esprit.Projet.Tests;

import Esprit.Projet.Entities.Publication;
import Esprit.Projet.Services.PublicationCRUD;
import Esprit.Projet.Utils.MyConnection;
import java.sql.SQLException;

/**
 *
 * @author ASUS
 */
public class MainClass {
    public static void main(String[] args) throws SQLException, ClassNotFoundException {
        //MyConnection Mc =new MyConnection();
        MyConnection mc = MyConnection.getInstance();
        MyConnection mc2 =MyConnection.getInstance();
        System.out.println(mc.hashCode()+" - "+mc2.hashCode());
        
        
        
        PublicationCRUD pcd = new PublicationCRUD();
        Publication p2 = new Publication("test7", "test8");
       // pcd.AddPublication2(p2);
        pcd.updatePublication(p2,3);
         //pcd.deletePublication(2);
         System.out.println(pcd.afficherPublication());
    }
}
