/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Esprit.Projet.Entities;

/**
 *
 * @author ASUS
 */
public class Publication {
    private int id;
    public String text;
    public String auteur_pub;

    public Publication(int id, String text, String auteur_pub) {
        this.id = id;
        this.text = text;
        this.auteur_pub = auteur_pub;
    }
    
    public Publication(){}

    public Publication(String text, String auteur_pub) {
        this.text = text;
        this.auteur_pub = auteur_pub;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getText() {
        return text;
    }

    public void setText(String text) {
        this.text = text;
    }

    public String getAuteur_pub() {
        return auteur_pub;
    }

    public void setAuteur_pub(String auteur_pub) {
        this.auteur_pub = auteur_pub;
    }

    @Override
    public String toString() {
        return "Publication{" + "id=" + id + ", text=" + text + ", auteur_pub=" + auteur_pub + '}';
    }
    
    
    
}
