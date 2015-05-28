using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

using System.Data.SqlClient;
using System.Configuration;
using System.Data;
public partial class Admin_Fotograf_rediger : System.Web.UI.Page
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

            cmd.CommandText = "SELECT * FROM Fotograf WHERE Id = @id";
            cmd.Parameters.AddWithValue("@id", Request.QueryString["id"]);


            SqlDataReader reader = cmd.ExecuteReader();
            if (reader.Read())
            {
                LabelId.Text = reader["id"].ToString();
                TextBoxNavn.Text = reader["Navn"].ToString();
                TextBoxBrugernavn.Text = reader["brugernavn"].ToString();
                TextBoxPassword.Text = reader["password"].ToString();
            }
            conn.Close();
        }
    }
    protected void ButtonGem_Click(object sender, EventArgs e)
    {
        SqlConnection conn = new SqlConnection();
        SqlCommand cmd = new SqlCommand();

        conn.ConnectionString = ConfigurationManager.ConnectionStrings["DatabaseConnectionString1"].ToString();
        cmd.Connection = conn;

        conn.Open();

        cmd.CommandText = "UPDATE Fotograf SET Navn = @Navn, brugernavn = @brugernavn, password = @password WHERE Id = @id";
        cmd.Parameters.AddWithValue("@id", Request.QueryString["id"]);
        cmd.Parameters.AddWithValue("@Navn", TextBoxNavn.Text);
        cmd.Parameters.AddWithValue("@brugernavn", TextBoxBrugernavn.Text);
        cmd.Parameters.AddWithValue("@password", TextBoxPassword.Text);

        cmd.ExecuteNonQuery();

        conn.Close();

        Response.Redirect(".");
    }
}