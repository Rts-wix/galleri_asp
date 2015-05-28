using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

using System.Data.SqlClient;
using System.Configuration;
using System.Data;
using System.IO;
public partial class Admin_Album_rediger : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        if (!IsPostBack)
        {
            SqlConnection conn = new SqlConnection();
            SqlCommand cmd = new SqlCommand();

            conn.ConnectionString = ConfigurationManager.ConnectionStrings["DatabaseConnectionString1"].ToString();
            cmd.Connection = conn;

            conn.Open();

            cmd.CommandText = "SELECT * FROM album";
            SqlDataReader reader = cmd.ExecuteReader();
            DropDownListAlbums.DataTextField = "Navn";
            DropDownListAlbums.DataValueField = "Id";
            DropDownListAlbums.DataSource = reader;
            DropDownListAlbums.DataBind();
            reader.Close();

            cmd.CommandText = "SELECT * FROM Fotograf";
            reader = cmd.ExecuteReader();
            DropDownListFotograf.DataTextField = "Navn";
            DropDownListFotograf.DataValueField = "Id";
            DropDownListFotograf.DataSource = reader;
            DropDownListFotograf.DataBind();
            reader.Close();

            cmd.CommandText = "SELECT * FROM Billede WHERE Id = @id";
            cmd.Parameters.AddWithValue("@id", Request.QueryString["id"]);

            reader = cmd.ExecuteReader();
            if (reader.Read())
            {
                LabelId.Text = reader["id"].ToString();
                TextBoxBilledenavn.Text = reader["billednavn"].ToString();
                TextBoxBeskrivelse.Text = reader["beskrivelse"].ToString();
                ImageInDB.ImageUrl = "/foto_ikon/" + reader["billedfilnavn"].ToString().Trim();
               
                DropDownListAlbums.SelectedValue = reader["fkAlbumId"].ToString();
                DropDownListFotograf.SelectedValue = reader["fkFotografId"].ToString();
            }
            conn.Close();
        }
    }
    protected void ButtonGem_Click(object sender, EventArgs e)
    {
        if (!FileUploadBilledefil.HasFile)
        {
            SqlConnection conn = new SqlConnection();
            SqlCommand cmd = new SqlCommand();

            conn.ConnectionString = ConfigurationManager.ConnectionStrings["DatabaseConnectionString1"].ToString();
            cmd.Connection = conn;

            conn.Open();

            cmd.CommandText = @"UPDATE Billede 
                                    SET billednavn = @billednavn, beskrivelse = @beskrivelse, 
                                    fkAlbumId = @fkAlbumId, fkFotografId = @fkFotografId 
                                    WHERE Id = @id";
            cmd.Parameters.AddWithValue("@id", Request.QueryString["id"]);
            cmd.Parameters.AddWithValue("@billednavn", TextBoxBilledenavn.Text);
            cmd.Parameters.AddWithValue("@beskrivelse", TextBoxBeskrivelse.Text);
            cmd.Parameters.AddWithValue("@fkAlbumId", DropDownListAlbums.SelectedValue);
            cmd.Parameters.AddWithValue("@fkFotografId", DropDownListFotograf.SelectedValue);

            cmd.ExecuteNonQuery();

            conn.Close();

            Response.Redirect(".");
        }
        else
        {
            string imagePath = Server.MapPath("/foto");
            string guid = Guid.NewGuid().ToString();
            string billedfilnavn = imagePath + "/" + guid + ".png";
            string billedIkonNavn = imagePath + "_ikon/" + guid + ".png";
            ImageNet.FluentImage image = ImageNet.FluentImage.FromStream(FileUploadBilledefil.FileContent);
            image.Resize.Scale(900).Save(billedfilnavn);
            image.Resize.Scale(150).Save(billedIkonNavn);

            if (File.Exists(billedfilnavn) && File.Exists(billedIkonNavn))
            {
                SqlConnection conn = new SqlConnection();
                SqlCommand cmd = new SqlCommand();

                conn.ConnectionString = ConfigurationManager.ConnectionStrings["DatabaseConnectionString1"].ToString();
                cmd.Connection = conn;

                conn.Open();

                cmd.CommandText = @"UPDATE Billede 
                                    SET billednavn = @billednavn, beskrivelse = @beskrivelse, 
                                    billedfilnavn = @billedfilnavn, 
                                    fkAlbumId = @fkAlbumId, fkFotografId = @fkFotografId 
                                    WHERE Id = @id";
                cmd.Parameters.AddWithValue("@id", Request.QueryString["id"]);
                cmd.Parameters.AddWithValue("@billednavn", TextBoxBilledenavn.Text);
                cmd.Parameters.AddWithValue("@beskrivelse", TextBoxBeskrivelse.Text);
                cmd.Parameters.AddWithValue("@billedfilnavn", guid + ".png");
                cmd.Parameters.AddWithValue("@fkAlbumId", DropDownListAlbums.SelectedValue);
                cmd.Parameters.AddWithValue("@fkFotografId", DropDownListFotograf.SelectedValue);

                cmd.ExecuteNonQuery();

                conn.Close();

                Response.Redirect(".");
            }
        }
    }
}