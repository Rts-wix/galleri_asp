<%@ Page Title="" Language="C#" MasterPageFile="~/MasterPage.master" AutoEventWireup="true" CodeFile="slet.aspx.cs" Inherits="Admin_Album_opret" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder_head" runat="Server">
    <link href="/css/Admin.css" rel="stylesheet" />
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder_Content" runat="Server">

    <div id="content_top">
        <div id="content_top_album">
            <h1>Slet Album</h1>
        </div>
        <div id="content_ikon" class="content">
            <p>Er du virkelig siker på at du vil slette følgende Album?</p>
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
                <asp:Button ID="ButtonSlet" runat="server" Text="Slet" OnClick="ButtonSlet_Click" />
            </p>
        </div>
    </div>

</asp:Content>

