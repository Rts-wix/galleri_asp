<%@ Page Title="" Language="C#" MasterPageFile="~/MasterPage.master" AutoEventWireup="true" CodeFile="Default.aspx.cs" Inherits="Admin_Album_Default" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder_head" runat="Server">
    <link href="/css/Admin.css" rel="stylesheet" />
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder_Content" runat="Server">

    <div id="content_top">
        <div id="content_top_album">
            <h1>Album</h1>
        </div>
        <div id="content_ikon" class="content">
            <p>
                <span class="label"></span><a href="opret.aspx" class="btn">Ny</a>
            </p>
            <asp:Repeater ID="RepeaterAlbumListe" runat="server" DataSourceID="SqlDataSourceAlbumListe">
                <ItemTemplate>
                    <p>
                        <strong class="label"><%# Eval("Navn") %></strong>
                        <a href="rediger.aspx?id=<%# Eval("id") %>" class="btn">Rediger</a>
                        <a href="vis.aspx?id=<%# Eval("id") %>" class="btn">Vis</a>
                        <a href="slet.aspx?id=<%# Eval("id") %>" class="btn">Slet</a>
                    </p>
                </ItemTemplate>
            </asp:Repeater>
            <asp:SqlDataSource runat="server" ID="SqlDataSourceAlbumListe" ConnectionString='<%$ ConnectionStrings:DatabaseConnectionString1 %>' SelectCommand="SELECT * FROM [Album]"></asp:SqlDataSource>


        </div>
</asp:Content>

