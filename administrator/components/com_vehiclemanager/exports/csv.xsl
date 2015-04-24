<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="text" encoding="utf-8"/>
    <xsl:template match="/">
        <xsl:for-each select="vechicles_data/vechicles_list/vehicle">
            <xsl:value-of select="asset_id"/><xsl:text>|</xsl:text>
            <xsl:value-of select="vehicleid"/><xsl:text>|</xsl:text>
            <xsl:value-of select="catid"/><xsl:text>|</xsl:text>
            <xsl:value-of select="sid"/><xsl:text>|</xsl:text>
            <xsl:value-of select="fk_rentid"/><xsl:text>|</xsl:text>
            <xsl:value-of select="description"/><xsl:text>|</xsl:text>
            <xsl:value-of select="link"/><xsl:text>|</xsl:text>
            <xsl:value-of select="listing_type"/><xsl:text>|</xsl:text>
            <xsl:value-of select="price"/><xsl:text>|</xsl:text>
            <xsl:value-of select="priceunit"/><xsl:text>|</xsl:text>
            <xsl:value-of select="vtitle"/><xsl:text>|</xsl:text>
            <xsl:value-of select="maker"/><xsl:text>|</xsl:text>
            <xsl:value-of select="vmodel"/><xsl:text>|</xsl:text>
            <xsl:value-of select="vtype"/><xsl:text>|</xsl:text>
            <xsl:value-of select="vlocation"/><xsl:text>|</xsl:text>
            <xsl:value-of select="vlatitude"/><xsl:text>|</xsl:text>
            <xsl:value-of select="vlongitude"/><xsl:text>|</xsl:text>
            <xsl:value-of select="map_zoom"/><xsl:text>|</xsl:text>
            <xsl:value-of select="contacts"/><xsl:text>|</xsl:text>
            <xsl:value-of select="year"/><xsl:text>|</xsl:text>
            <xsl:value-of select="vcondition"/><xsl:text>|</xsl:text>
            <xsl:value-of select="mileage"/><xsl:text>|</xsl:text>
            <xsl:value-of select="image_link"/><xsl:text>|</xsl:text>
            <xsl:value-of select="listing_status"/><xsl:text>|</xsl:text>
            <xsl:value-of select="price_type"/><xsl:text>|</xsl:text>
            <xsl:value-of select="transmission"/><xsl:text>|</xsl:text>
            <xsl:value-of select="num_speed"/><xsl:text>|</xsl:text>
            <xsl:value-of select="interior_color"/><xsl:text>|</xsl:text>
            <xsl:value-of select="exterior_color"/><xsl:text>|</xsl:text>
            <xsl:value-of select="doors"/><xsl:text>|</xsl:text>
            <xsl:value-of select="engine"/><xsl:text>|</xsl:text>
            <xsl:value-of select="fuel_type"/><xsl:text>|</xsl:text>
            <xsl:value-of select="drive_type"/><xsl:text>|</xsl:text>
            <xsl:value-of select="cylinder"/><xsl:text>|</xsl:text>
            <xsl:value-of select="wheelbase"/><xsl:text>|</xsl:text>
            <xsl:value-of select="seating"/><xsl:text>|</xsl:text>
            <xsl:value-of select="city_fuel_mpg"/><xsl:text>|</xsl:text>
            <xsl:value-of select="highway_fuel_mpg"/><xsl:text>|</xsl:text>
            <xsl:value-of select="wheeltype"/><xsl:text>|</xsl:text>
            <xsl:value-of select="rear_axe_type"/><xsl:text>|</xsl:text>
            <xsl:value-of select="brakes_type"/><xsl:text>|</xsl:text>
            <xsl:value-of select="exterior_amenities"/><xsl:text>|</xsl:text>
            <xsl:value-of select="dashboard_options"/><xsl:text>|</xsl:text>
            <xsl:value-of select="interior_amenities"/><xsl:text>|</xsl:text>
            <xsl:value-of select="safety_options"/><xsl:text>|</xsl:text>
            <xsl:value-of select="w_basic"/><xsl:text>|</xsl:text>
            <xsl:value-of select="w_drivetrain"/><xsl:text>|</xsl:text>
            <xsl:value-of select="w_corrosion"/><xsl:text>|</xsl:text>
            <xsl:value-of select="w_roadside_ass"/><xsl:text>|</xsl:text>
            <xsl:value-of select="checked_out"/><xsl:text>|</xsl:text>
            <xsl:value-of select="checked_out_time"/><xsl:text>|</xsl:text>
            <xsl:value-of select="ordering"/><xsl:text>|</xsl:text>
            <xsl:value-of select="date"/><xsl:text>|</xsl:text>
            <xsl:value-of select="hits"/><xsl:text>|</xsl:text>    
            <xsl:value-of select="edok_link"/><xsl:text>|</xsl:text>
            <xsl:value-of select="published"/><xsl:text>|</xsl:text>
            <xsl:value-of select="approved"/><xsl:text>|</xsl:text>
            <xsl:value-of select="country"/><xsl:text>|</xsl:text>
            <xsl:value-of select="region"/><xsl:text>|</xsl:text>
            <xsl:value-of select="city"/><xsl:text>|</xsl:text>
            <xsl:value-of select="district"/><xsl:text>|</xsl:text>
            <xsl:value-of select="zipcode"/><xsl:text>|</xsl:text>
            <xsl:value-of select="owneremail"/><xsl:text>|</xsl:text>
            <xsl:value-of select="language"/><xsl:text>|</xsl:text>
            <xsl:value-of select="featured_clicks"/><xsl:text>|</xsl:text>
            <xsl:value-of select="featured_shows"/><xsl:text>|</xsl:text>
            <xsl:value-of select="extra1"/><xsl:text>|</xsl:text>
            <xsl:value-of select="extra2"/><xsl:text>|</xsl:text>
            <xsl:value-of select="extra3"/><xsl:text>|</xsl:text>
            <xsl:value-of select="extra4"/><xsl:text>|</xsl:text>
            <xsl:value-of select="extra5"/><xsl:text>|</xsl:text>
            <xsl:value-of select="extra6"/><xsl:text>|</xsl:text>
            <xsl:value-of select="extra7"/><xsl:text>|</xsl:text>
            <xsl:value-of select="extra8"/><xsl:text>|</xsl:text>
            <xsl:value-of select="extra9"/><xsl:text>|</xsl:text>
            <xsl:value-of select="extra10"/><xsl:text>|</xsl:text>
            <xsl:value-of select="video_link"/><xsl:text>|</xsl:text>
            <xsl:value-of select="owner_id"/><xsl:text>&#xA;</xsl:text>
        </xsl:for-each>
    </xsl:template>
</xsl:stylesheet>