<%@ Page Title="" Language="C#" MasterPageFile="~/MasterPage.master" AutoEventWireup="true" CodeFile="vis.aspx.cs" Inherits="Admin_Billede_vis" %>

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
                <span class="label">Billedenavn:</span>
                <asp:Label ID="LabelBilledenavn" runat="server"></asp:Label>
            </p>
            <p>
                <span class="label">Beskrivelse:</span>
                <asp:Label ID="LabelBeskrivelse" TextMode="MultiLine" runat="server"></asp:Label>
            </p>

            <p>
                <span class="label">Billedefil:</span>
                <asp:Image ID="ImageInDB" runat="server" />

            </p>

            <p>
                <span class="label">Album:</span>
                <asp:Label ID="LabelAlbum" runat="server"></asp:Label>
            </p>
            <p>
                <span class="label">Fotograf:</span>
                <asp:Label ID="LabelFotograf" runat="server"></asp:Label>
            </p>
            <p>
                <span class="label"></span>
                <asp:Button ID="ButtonTilbage" runat="server" Text="Tilbage" OnClick="ButtonTilbage_Click" />
            </p>
        </div>
    </div>
</asp:Content>

