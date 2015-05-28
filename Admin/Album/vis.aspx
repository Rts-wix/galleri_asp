<%@ Page Title="" Language="C#" MasterPageFile="~/MasterPage.master" AutoEventWireup="true" CodeFile="vis.aspx.cs" Inherits="Admin_Album_opret" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder_head" runat="Server">
    <link href="/css/Admin.css" rel="stylesheet" />
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder_Content" runat="Server">

    <div id="content_top">
        <div id="content_top_album">
            <h1>Vis Album</h1>
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
                <span class="label"></span>
                <asp:Button ID="ButtonTilbage" runat="server" Text="Tilbage" OnClick="ButtonTilbage_Click" />
            </p>
</asp:Content>

