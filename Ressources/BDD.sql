#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: COUNTER
#------------------------------------------------------------

CREATE TABLE COUNTER(
        id_counter    Int NOT NULL ,
        force_counter Int NOT NULL
	,CONSTRAINT COUNTER_PK PRIMARY KEY (id_counter)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: HEROS
#------------------------------------------------------------

CREATE TABLE HEROS(
        id_counter       Int NOT NULL ,
        id_heros         Int NOT NULL ,
        nom_heros        Varchar (15) NOT NULL ,
        image_mini_heros Varchar (15) NOT NULL ,
        image_maxi_heros Varchar (15) NOT NULL ,
        type_heros       Varchar (15) NOT NULL ,
        force_counter    Int NOT NULL
	,CONSTRAINT HEROS_PK PRIMARY KEY (id_counter,id_heros)

	,CONSTRAINT HEROS_COUNTER_FK FOREIGN KEY (id_counter) REFERENCES COUNTER(id_counter)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: JOUEUR
#------------------------------------------------------------

CREATE TABLE JOUEUR(
        id_joueur     Int NOT NULL ,
        pseudo_joueur Varchar (15) NOT NULL ,
        email_joueur  Varchar (15) NOT NULL ,
        mdp_joueur    Varchar (15) NOT NULL ,
        rang_joueur   Varchar (15) NOT NULL ,
        avatar_joueur Varchar (15) NOT NULL ,
        poste_joueur  Varchar (15) NOT NULL ,
        id_counter    Int NOT NULL ,
        id_heros      Int NOT NULL
	,CONSTRAINT JOUEUR_PK PRIMARY KEY (id_joueur)

	,CONSTRAINT JOUEUR_HEROS_FK FOREIGN KEY (id_counter,id_heros) REFERENCES HEROS(id_counter,id_heros)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: EQUIPE
#------------------------------------------------------------

CREATE TABLE EQUIPE(
        id_equipe     Int NOT NULL ,
        nom_equipe    Varchar (15) NOT NULL ,
        slogan_equipe Varchar (15) NOT NULL ,
        avatar_equipe Varchar (15) NOT NULL ,
        id_joueur     Int NOT NULL
	,CONSTRAINT EQUIPE_PK PRIMARY KEY (id_equipe)

	,CONSTRAINT EQUIPE_JOUEUR_FK FOREIGN KEY (id_joueur) REFERENCES JOUEUR(id_joueur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: COACH
#------------------------------------------------------------

CREATE TABLE COACH(
        id_coach     Int NOT NULL ,
        pseudo_coach Varchar (15) NOT NULL ,
        email_coach  Varchar (15) NOT NULL ,
        mdp_coach    Varchar (15) NOT NULL ,
        id_equipe    Int NOT NULL
	,CONSTRAINT COACH_PK PRIMARY KEY (id_coach)

	,CONSTRAINT COACH_EQUIPE_FK FOREIGN KEY (id_equipe) REFERENCES EQUIPE(id_equipe)
)ENGINE=InnoDB;

