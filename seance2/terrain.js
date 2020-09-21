function clicTableau(obj)
{
    switch (obj.className)
    {
        case "blanc":
            obj.className = "noir";
            break;
        case "noir":
            obj.className = "";
            break;
        default:
            obj.className = "blanc";
    }
}