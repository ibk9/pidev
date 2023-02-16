/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Esprit.Projet.Services;

import Esprit.Projet.Entities.Publication;
import Esprit.Projet.Utils.MyConnection;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author ASUS
 */
public class PublicationCRUD {
    
    Connection cnx2;
    
    public PublicationCRUD(){
        cnx2=MyConnection.getInstance().getCnx();
    }
    
    public void AddPublication(){
        try {
            String requete ="INSERT INTO publication (text,auteur_pub)"
                    + "VALUES ('test1','test2')";
            
            //Statement st = new MyConnection().getCnx().createStatement();
            Statement st = cnx2.createStatement();
            st.executeUpdate(requete);
            System.out.println("Publication added successfully");
            
        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
    
    
    }
    
    
    
    
    
    
    
    
    
    public void AddPublication2(Publication p){
    try {
            String requete2 ="INSERT INTO publication (text,auteur_pub)"
                    + "VALUES (?,?)";
            
            //PreparedStatement pst = new MyConnection().getCnx().prepareStatement(requete2);
            PreparedStatement pst = cnx2.prepareStatement(requete2);
            pst.setString(1,p.getText());
            pst.setString(2,p.getAuteur_pub());
            pst.executeUpdate();
            System.out.println("Add application");
            
            System.out.println("Publication added successfully");
            
        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
        }
    
    
    public void updatePublication(Publication p, int id) {
        try {
        String requete2 = "UPDATE publication set text = ? , auteur_pub = ? , where id = ?";
//        Connection conn = DBConnection.getDBConnection().getConnection();
        PreparedStatement pst = cnx2.prepareStatement(requete2);
        
        pst.setObject(1, p.getText());
        pst.setObject(2, p.getAuteur_pub());        
        pst.setObject(3, p.getId());
         pst.executeUpdate();
            System.out.println("Add application");
            
            System.out.println("Publication added successfully");
        
        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
    }
    
    }
    
    
    
    
    
    
    
    
   public boolean deletePublication(int Id) throws SQLException, ClassNotFoundException{
    String requete2 = "Delete from publication where id = ?";
      // Connection conn = DBConnection.getDBConnection().getConnection();
      PreparedStatement pst = cnx2.prepareStatement(requete2);
        pst.setObject(1,Id);
       return pst.executeUpdate() > 0;
  }
    
    
    
    
    
    
    
        
    
    
    public List<Publication> afficherPublication(){
        List<Publication> myList=new ArrayList<>();
        try {
            
            String requete3 = "SELECT * FROM Publication";
           // Statement st = new MyConnection().getCnx().createStatement();
           Statement st = cnx2.createStatement();
            ResultSet rs = st.executeQuery(requete3);
            
            while(rs.next()){
                Publication p=new Publication();
                
                p.setId(rs.getInt(1));
                p.setText(rs.getString("text"));
                p.setAuteur_pub(rs.getString("auteur_pub"));
                myList.add(p);
            }
            
            
        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
        
    return myList;
    }
    
}
