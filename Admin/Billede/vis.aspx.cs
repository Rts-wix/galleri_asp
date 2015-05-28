using System;
using System.Collections.Generic;
using System.Configuration;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

public partial class Admin_Billede_vis : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        SqlConnection conn = new SqlConnection();
        SqlCommand cmd = new SqlCommand();

        conn.ConnectionString = ConfigurationManager.ConnectionStrings["DatabaseConnectionString1"].ToString();
        cmd.Connection = conn;

        conn.Open();

        cmd.CommandText = @"SELECT Billede.*, Album.Navn as albumNavn, Fotograf.Navn as fotografNavn 
                            FROM Billede 
                                INNER JOIN Album ON Album.Id = Billede.fkAlbumId
                                INNER JOIN Fotograf ON Fotograf.Id = Billede.fkFotografId
                            WHERE Billede.Id = @id";
        cmd.Parameters.AddWithValue("@id", Request.QueryString["id"]);
       
 
        SqlDataReader reader = cmd.ExecuteReader();
        if (reader.Read())
        {
            LabelId.Text = reader["id"].ToString();
            LabelBilledenavn.Text = reader["billednavn"].ToString();
            LabelBeskrivelse.Text = reader["beskrivelse"].ToString();
            ImageInDB.ImageUrl = "/foto_ikon/" + reader["billedfilnavn"].ToString().Trim();

            LabelAlbum.Text = reader["albumNavn"].ToString();
            LabelFotograf.Text = reader["fotografNavn"].ToString();
        }
        conn.Close();
    }
    protected void ButtonTilbage_Click(object sender, EventArgs e)
    {
        Response.Redirect(".");
    }
}