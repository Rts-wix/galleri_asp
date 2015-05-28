using System;
using System.Collections.Generic;
using System.Configuration;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

public partial class Admin_Album_opret : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {

    }
    protected void ButtonGem_Click(object sender, EventArgs e)
    {

        SqlConnection conn = new SqlConnection();
        SqlCommand cmd = new SqlCommand();

        conn.ConnectionString = ConfigurationManager.ConnectionStrings["DatabaseConnectionString1"].ToString();
        cmd.Connection = conn;

        conn.Open();

        cmd.CommandText = "INSERT INTO album (Navn) VALUES (@Navn)";
        cmd.Parameters.AddWithValue("@Navn", TextBoxNavn.Text);

        cmd.ExecuteNonQuery();

        conn.Close();

        Response.Redirect(".");
    }
}