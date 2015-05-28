CREATE TABLE [dbo].[Billede] (
    [Id]            INT            IDENTITY (1, 1) NOT NULL,
    [billednavn]    NVARCHAR (50)  NULL,
    [beskrivelse]   NVARCHAR (MAX) NULL,
    [billedfilnavn] NCHAR (62)     NOT NULL,
    [fkAlbumId]     INT            NOT NULL,
    [fkFotografId]  INT            NOT NULL,
    PRIMARY KEY CLUSTERED ([Id] ASC),
    CONSTRAINT [FK_Billede_Album] FOREIGN KEY ([fkAlbumId]) REFERENCES [dbo].[Album] ([Id]),
    CONSTRAINT [FK_Billede_Fotograf] FOREIGN KEY ([fkFotografId]) REFERENCES [dbo].[Fotograf] ([Id])
);

