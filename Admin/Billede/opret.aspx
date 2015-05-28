<%@ Page Title="" Language="C#" MasterPageFile="~/MasterPage.master" AutoEventWireup="true" CodeFile="opret.aspx.cs" Inherits="Admin_Billede_opret" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder_head" runat="Server">
    <link href="/css/Admin.css" rel="stylesheet" />
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder_Content" runat="Server">

    <div id="content_top">
        <div id="content_top_album">
            <h1>Opret Album</h1>
        </div>
        <div id="content_ikon" class="content">

            <p>
                <span class="label">Billedenavn:</span>
                <asp:TextBox ID="TextBoxBilledenavn" runat="server"></asp:TextBox>
            </p>
            <p>
                <span class="label">Beskrivelse:</span>
                <asp:TextBox ID="TextBoxBeskrivelse" TextMode="MultiLine" runat="server"></asp:TextBox>
            </p>

            <p>
                <span class="label">Billedefil:</span>
                <asp:FileUpload ID="FileUploadBilledefil" runat="server"/>
            </p>

            <p>
                <span class="label">Album:</span>
                <asp:DropDownList ID="DropDownListAlbums" runat="server"></asp:DropDownList>
            </p>
            <p>
                <span class="label">Fotograf:</span>
                <asp:DropDownList ID="DropDownListFotograf" runat="server"></asp:DropDownList>
            </p>
            <p>
                <span class="label"></span>
                <asp:Button ID="ButtonGem" runat="server" Text="Gem" OnClick="ButtonGem_Click" />
            </p>
        </div>
    </div>
</asp:Content>

