using System;
using System.Collections.Generic;
using System.Configuration;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

using System.IO;

public partial class Admin_Billede_opret : System.Web.UI.Page
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

            conn.Close();
        }
    }
    protected void ButtonGem_Click(object sender, EventArgs e)
    {
        if (FileUploadBilledefil.HasFile)
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

                cmd.CommandText = @"INSERT INTO Billede (billednavn, beskrivelse, billedfilnavn, fkAlbumId, fkFotografId) 
                            VALUES (@billednavn, @beskrivelse, @billedfilnavn, @fkAlbumId, @fkFotografId)";
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