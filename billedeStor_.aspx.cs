using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

public partial class billedeStor : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        SqlDataSourceBillede.SelectCommand = "SELECT * FROM [Billede] WHERE Id = @billedeId";
        SqlDataSourceBillede.SelectParameters.Add("billedeId", Request.QueryString["billedeId"]);

    }
}