using System;
using System.Collections.Generic;
using System.Configuration;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

using System.IO;

public partial class Admin_Album_opret : System.Web.UI.Page
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
    protected void ButtonSlet_Click(object sender, EventArgs e)
    {

        SqlConnection conn = new SqlConnection();
        SqlCommand cmd = new SqlCommand();

        conn.ConnectionString = ConfigurationManager.ConnectionStrings["DatabaseConnectionString1"].ToString();
        cmd.Connection = conn;

        conn.Open();

        cmd.CommandText = "SELECT billedfilnavn FROM Billede WHERE Id = @Id";
        cmd.Parameters.AddWithValue("@id", Request.QueryString["id"]);
        string billedfilnavn = cmd.ExecuteScalar().ToString();

        try
        {
            File.Delete(billedfilnavn);
        }
        catch(Exception)
        { }

        cmd.CommandText = "DELETE FROM Billede WHERE Id = @id";
        cmd.ExecuteNonQuery();

        conn.Close();

        Response.Redirect(".");
    }
    protected void ButtonTilbage_Click(object sender, EventArgs e)
    {
        Response.Redirect(".");
    }
}