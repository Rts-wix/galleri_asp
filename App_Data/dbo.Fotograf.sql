CREATE TABLE [dbo].[Fotograf] (
    [Id]         INT            IDENTITY (1, 1) NOT NULL,
    [Navn]       NVARCHAR (100) NULL,
    [brugernavn] NVARCHAR (20)  NULL,
    [password]   NVARCHAR (50)  NULL,
    PRIMARY KEY CLUSTERED ([Id] ASC)
);

