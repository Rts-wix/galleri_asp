<%@ Page Title="" Language="C#" MasterPageFile="~/MasterPage.master" AutoEventWireup="true" CodeFile="vis.aspx.cs" Inherits="Admin_Fotograf_vis" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder_head" runat="Server">
    <link href="/css/Admin.css" rel="stylesheet" />
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder_Content" runat="Server">

    <div id="content_top">
        <div id="content_top_album">
            <h1>Vis Fotograf</h1>
        </div>
        <div id="content_ikon" class="content">
            <p>
                <span class="label">Id:</span>
                <asp:Label ID="LabelId" runat="server" Text=""></asp:Label>
            </p>
            <p>
                <span class="label">Navn:</span>
                <asp:Label ID="LabelNavn" runat="server"></asp:Label>
            </p>
            <p>
                <span class="label">Brugernavn:</span>
                <asp:Label ID="LabelBrugernavn" runat="server"></asp:Label>
            </p>

            <p>
                <span class="label">Paswword:</span>
                <asp:Label ID="LabelPassword" runat="server"></asp:Label>
            </p>
            <p>
                <span class="label"></span>
                <asp:Button ID="ButtonTilbage" runat="server" Text="Tilbage" OnClick="ButtonTilbage_Click" />
            </p>
            </div>
        </div>
</asp:Content>

