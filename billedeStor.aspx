<%@ Page Title="" Language="C#" MasterPageFile="~/MasterPage.master" AutoEventWireup="true" CodeFile="billedeStor.aspx.cs" Inherits="billedeStor" %>

<asp:Content ID="Content1" ContentPlaceHolderID="ContentPlaceHolder_head" Runat="Server">
</asp:Content>
<asp:Content ID="Content2" ContentPlaceHolderID="ContentPlaceHolder_Content" Runat="Server">
    <asp:Repeater ID="RepeaterBillede" runat="server" DataSourceID="SqlDataSourceBillede">
        <ItemTemplate>
            <img src="foto/<%# Eval("billedfilnavn") %>" />
        </ItemTemplate>
    </asp:Repeater>
    <asp:SqlDataSource runat="server" ID="SqlDataSourceBillede" ConnectionString='<%$ ConnectionStrings:DatabaseConnectionString1 %>' 
        SelectCommand="SELECT [billedfilnavn] FROM [Billede] WHERE ([Id] = @Id)">
        <SelectParameters>
            <asp:QueryStringParameter QueryStringField="billedeId" Name="Id" Type="Int32"></asp:QueryStringParameter>
        </SelectParameters>
    </asp:SqlDataSource>
</asp:Content>

