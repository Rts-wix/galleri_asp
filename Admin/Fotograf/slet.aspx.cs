using System;
using System.Collections.Generic;
using System.Configuration;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

public partial class Admin_Fotograf_slet : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
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
            LabelNavn.Text = reader["Navn"].ToString();
            LabelBrugernavn.Text = reader["brugernavn"].ToString();
            LabelPassword.Text = reader["password"].ToString();
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

        cmd.CommandText = "DELETE FROM Fotograf WHERE Id = @id";
        cmd.Parameters.AddWithValue("@id", Request.QueryString["id"]);

        cmd.ExecuteNonQuery();

        conn.Close();

        Response.Redirect(".");
    }
}