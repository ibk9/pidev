/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Esprit.Projet.Utils;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author ASUS
 */
public class MyConnection {
    public String URL="jdbc:mysql://localhost:3306/galeria";
    public String LOGIN="root";
    public String PWD="";
    Connection cnx;
    public static MyConnection instance;
    
    
    private MyConnection(){
        try {
          cnx = DriverManager.getConnection(URL, LOGIN, PWD);
            System.out.println("Connected");
        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        }
        
    }
    
    public Connection getCnx(){
    
        return cnx;
    }
    
    public static MyConnection getInstance(){
        if(instance==null){
            instance = new MyConnection();
        }
        return instance;
    }
    
}
