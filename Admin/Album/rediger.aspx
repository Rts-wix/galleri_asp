<%@ Page Title="" Language="C#" MasterPageFile="~/MasterPage.master" AutoEventWireup="true" CodeFile="rediger.aspx.cs" Inherits="Admin_Album_rediger" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder_head" runat="Server">
    <link href="/css/Admin.css" rel="stylesheet" />
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder_Content" runat="Server">

    <div id="content_top">
        <div id="content_top_album">
            <h1>Album rediger</h1>
        </div>
        <div id="content_ikon" class="content">

            <p>
                <span class="label">Id:</span>
                <asp:Label ID="LabelId" runat="server" Text="Label"></asp:Label>
            </p>
            <p>
                <span class="label">Navn:</span>
                <asp:TextBox ID="TextBoxNavn" runat="server"></asp:TextBox>
            </p>
            <p>
                <span class="label"></span>
                <asp:Button ID="ButtonGem" runat="server" Text="Gem" OnClick="ButtonGem_Click" />
            </p>
        </div>
    </div>
</asp:Content>

