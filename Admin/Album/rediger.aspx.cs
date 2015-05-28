using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

using System.Data.SqlClient;
using System.Configuration;
using System.Data;
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

            cmd.CommandText = "SELECT * FROM album WHERE Id = @id";
            cmd.Parameters.AddWithValue("@id", Request.QueryString["id"]);


            SqlDataReader reader = cmd.ExecuteReader();
            if (reader.Read())
            {
                LabelId.Text = reader["id"].ToString();
                TextBoxNavn.Text = reader["Navn"].ToString();
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

        cmd.CommandText = "UPDATE Album SET Navn = @Navn WHERE Id = @id";
        cmd.Parameters.AddWithValue("@id", Request.QueryString["id"]);
        cmd.Parameters.AddWithValue("@Navn", TextBoxNavn.Text);

        cmd.ExecuteNonQuery();

        conn.Close();

        Response.Redirect(".");
    }
}