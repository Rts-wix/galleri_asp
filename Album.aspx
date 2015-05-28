<%@ Page Title="" Language="C#" MasterPageFile="~/MasterPage.master" AutoEventWireup="true" CodeFile="Album.aspx.cs" Inherits="Album" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder_head" Runat="Server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder_Content" Runat="Server">
   

            <div id="content_top">
                    <div id="content_top_album">
                        <asp:Repeater ID="RepeaterAlbumNavn" runat="server" DataSourceID="SqlDataSourceAlbumNavn">
                            <ItemTemplate>
                                <h1><%# Eval("Navn") %></h1>
                            </ItemTemplate>
                        </asp:Repeater>
                        <asp:SqlDataSource runat="server" ID="SqlDataSourceAlbumNavn" 
                            ConnectionString='<%$ ConnectionStrings:DatabaseConnectionString1 %>' 
                            SelectCommand="SELECT [Navn] FROM [Album]"></asp:SqlDataSource>
                    </div>
                </div>

                <div id="content_ikon">

                    <asp:Repeater ID="RepeaterBillede" runat="server" DataSourceID="SqlDataSourceAlbum">
                        <ItemTemplate>

                            <div class="ikon">
                                <a href="billedeStor.aspx?billedeId=<%# Eval("Id") %>">
                                    <img 
                                        src="foto_ikon/<%# Eval("billedfilnavn") %>"
                                        alt="<%# Eval("beskrivelse") %>" />
                                </a>
                            </div>

                        </ItemTemplate>
                    </asp:Repeater>
                    <asp:SqlDataSource runat="server" 
                        ID="SqlDataSourceAlbum" 
                        ConnectionString='<%$ ConnectionStrings:DatabaseConnectionString1 %>' 
                        SelectCommand="SELECT * FROM [Billede]"></asp:SqlDataSource>
                </div>				


</asp:Content>

