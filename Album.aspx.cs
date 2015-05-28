using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

public partial class Album : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        // her checker vi om det er et album der skal vises
        int id = -1;
        string albumid = Request.QueryString["albumid"];
        string fotografid = Request.QueryString["fotografid"];

        if (albumid != null && int.TryParse(albumid, out id) && id > 0)
        {
            SqlDataSourceAlbumNavn.SelectCommand = "SELECT * FROM [Album] WHERE Id = @albumid";
            SqlDataSourceAlbumNavn.SelectParameters.Add("albumid", albumid);

            SqlDataSourceAlbum.SelectCommand = "SELECT * FROM [Billede] WHERE fkAlbumId = @albumid";
            SqlDataSourceAlbum.SelectParameters.Add("albumid", albumid);
        }

        else if (fotografid != null && int.TryParse(fotografid, out id) && id > 0)
        {
            SqlDataSourceAlbumNavn.SelectCommand = "SELECT * FROM [Fotograf] WHERE Id = @fotografid";
            SqlDataSourceAlbumNavn.SelectParameters.Add("fotografid", fotografid);

            SqlDataSourceAlbum.SelectCommand = "SELECT * FROM [Billede] WHERE fkFotografId = @fotografid";
            SqlDataSourceAlbum.SelectParameters.Add("fotografid", fotografid);
        }
        else
        {
            SqlDataSourceAlbumNavn.SelectCommand = "SELECT * FROM [Album] WHERE Id = 0";
            SqlDataSourceAlbum.SelectCommand = "SELECT * FROM [Billede] WHERE Id = 0";
        }
    }
}